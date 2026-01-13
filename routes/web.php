<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@home')->name('welcome');

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('user_registration', 'UserRegistrationController')->except(['show']);
    Route::get('user_registration/action_employee', 'UserRegistrationController@actionEmployee')->name('user_registration/action_employee.actionEmployee');
    Route::get('/ajax_depo_user', 'UserRegistrationController@ajax_depo_user');
    Route::get('/ajax_divisi', 'UserRegistrationController@ajax_divisi');
    Route::get('user_registration/update/{id}', 'UserRegistrationController@update_view')->name('user_registration/update.update_view');
    Route::post('user_registration/edit', 'UserRegistrationController@edit')->name('user_registration/edit.edit');

    Route::resource('ubah_password', 'UserResetController')->except(['create', 'show']);
    Route::post('ubah_password/edit', 'UserResetController@edit')->name('ubah_password/edit.edit');
    Route::post('reset', 'UserResetController@reset')->name('reset.reset');

    Route::resource('user_registrasi_luar', 'UserRegistrationLuarController')->except(['show']);
    Route::get('user_registrasi_luar/ajax_depo_user', 'UserRegistrationLuarController@ajax_depo_user');

    Route::resource('category', 'CategoryController')->except(['create', 'show']);
    Route::get('category/{id}', 'CategoryController@view')->name('category.view');
    Route::post('category/{kode}', 'CategoryController@hapus')->name('category.hapus');

    Route::resource('perusahaan', 'PerusahaanController')->except(['create', 'show']);
    Route::resource('perusahaan_korsis', 'PerusahaanKorsisController')->except(['create', 'show']);
    Route::resource('depo', 'DepoController')->except(['create', 'show']);
    Route::get('depo/cari', 'DepoController@cari')->name('depo.cari');
    Route::resource('depo_korsis', 'DepoKorsisController')->except(['create', 'show']);
    Route::get('depo_korsis/cari', 'DepoKorsisController@cari')->name('depo_korsis.cari');
    Route::resource('divisi', 'DivisiController')->except(['create', 'show']);
    Route::get('divisi/cari', 'DivisiController@cari')->name('divisi.cari');
    Route::resource('coa', 'Coa\AccountController')->except(['show']);
    Route::resource('coa_1', 'Coa\LayerSatuController')->except(['show']);
    Route::resource('coa_2', 'Coa\LayerDuaController')->except(['show']);
    Route::resource('coa_3', 'Coa\LayerTigaController')->except(['show']);
    Route::resource('coa_4', 'Coa\LayerEmpatController')->except(['show']);
    Route::post('/coa_1/index', 'Coa\LayerSatuController@storeData')->name('coa_1.storeData');
    Route::post('/coa_2/index', 'Coa\LayerDuaController@storeData')->name('coa_2.storeData');
    Route::post('/coa_3/index', 'Coa\LayerTigaController@storeData')->name('coa_3.storeData');
    Route::post('/coa_4/index', 'Coa\LayerEmpatController@storeData')->name('coa_4.storeData');
    Route::resource('coa_transaction', 'Coa\AccountTransaksiController')->except(['show']);
    Route::get('coa_transaction/action_coa', 'Coa\AccountTransaksiController@actionCoa')->name('coa_transaction/action_coa.actionCoa');
    Route::get('coa_transaction_kredit/action_coa_kredit', 'Coa\AccountTransaksiController@actionCoaKredit')->name('coa_transaction_kredit/action_coa_kredit.actionCoaKredit');
    Route::resource('product', 'ProductController')->except(['show']);
    Route::resource('product_import', 'ProductControllerImport')->except(['show']);
    Route::post('product_import/index', 'ProductControllerImport@storeDataProduct')->name('product_import.storeDataProduct');
    Route::get('product/{kode}', 'ProductController@view')->name('product.view');
    Route::post('product/update', 'ProductController@update')->name('product.update');
    Route::post('product/{kode}', 'ProductController@destroy')->name('product.destroy');
    Route::resource('area', 'AreaController')->except(['create', 'show']);
    Route::resource('area_sub', 'AreaSubController')->except(['create', 'show']);
    Route::resource('warehouse', 'WarehouseController')->except(['show']);
    Route::get('/ajax_depo_warehouse', 'WarehouseController@ajax_depo_warehouse');
    Route::get('warehouse/cari', 'WarehouseController@cari')->name('warehouse.cari');
    Route::post('warehouse/create', 'WarehouseController@store_2')->name('warehouse/create.store_2');
    Route::post('warehouse', 'WarehouseController@store_1')->name('warehouse.store_1');
    Route::get('warehouse/action_product', 'WarehouseController@actionProduct')->name('warehouse/action_product.actionProduct');
    Route::get('/ajax_area', 'WarehouseController@ajax_area');
    Route::resource('checker', 'CheckerController')->except(['create', 'show']);
    Route::get('/ajax', 'CheckerController@ajax');
    Route::get('checker/{doc_id}', 'CheckerController@view')->name('checker.view');
    Route::post('checker', 'CheckerController@store')->name('checker.store');
    Route::post('checker/update', 'CheckerController@update')->name('checker.update');
    Route::resource('pengeluaran', 'PengeluaranController')->except(['show']);
    Route::get('pengeluaran/action_coa', 'PengeluaranController@actionCoa')->name('pengeluaran/action_coa.actionCoa');
    Route::post('pengeluaran_simpan', 'PengeluaranController@store')->name('pengeluaran_simpan');

    Route::resource('piutang_master_rek', 'PiutangMasterNorekController')->except(['show']);
    Route::get('piutang_master_rek/getData', 'PiutangMasterNorekController@getData')->name('getData');
    Route::post('piutang_master_rek/store', 'PiutangMasterNorekController@store')->name('store');
    Route::get('piutang_master_rek/getDetailData', 'PiutangMasterNorekController@getDetailData')->name('getDetailData');
    Route::post('piutang_master_rek/update', 'PiutangMasterNorekController@update')->name('update');
    Route::post('piutang_master_rek/delete', 'PiutangMasterNorekController@delete')->name('delete');

    /**###Master Data Tarif BBM */
    Route::resource('tarif_bbm', 'Tarif_Bbm\TarifBbmController')->except(['show']);
    Route::get('tarif_bbm/update/{id}', 'Tarif_Bbm\TarifBbmController@update_view')->name('tarif_bbm/update.update_view');
    Route::post('tarif_bbm/edit', 'Tarif_Bbm\TarifBbmController@edit')->name('tarif_bbm/edit.edit');
    /**###END Master Data Tarif BBM */

    /**Master Data Budget ATK */
    Route::resource('budget_atk', 'Budget\BudgetAtkController')->except(['show']);
    Route::get('/ajax_depo_budget', 'Budget\BudgetAtkController@ajax_depo_budget');
    Route::get('budget_atk/update/{id}', 'Budget\BudgetAtkController@update_view')->name('budget_atk/update.update_view');
    Route::post('budget_atk/edit', 'Budget\BudgetAtkController@edit')->name('budget_atk/edit.edit');
    /**End Master Data Budget ATK */

    /**End Master Data List Asset */
    Route::resource('asset_list', 'AssetList\AssetController')->except(['show']);
    Route::get('asset_list/getDataAsset', 'AssetList\AssetController@getDataAsset')->name('asset_list/getDataAsset.getDataAsset');
    Route::post('asset_list/store', 'AssetList\AssetController@store')->name('asset_list/store.store');

    Route::resource('asset_pemegang', 'AssetList\PemegangAssetController')->except(['show']);
    Route::get('asset_pemegang/getDataPemegang', 'AssetList\PemegangAssetController@getDataPemegang')->name('asset_pemegang/getDataPemegang.getDataPemegang');
    Route::post('asset_pemegang/store', 'AssetList\PemegangAssetController@store')->name('asset_pemegang/store.store');

    Route::resource('asset_penempatan', 'AssetList\PenempatanAssetController')->except(['show']);
    Route::get('asset_penempatan/getDataPenempatan', 'AssetList\PenempatanAssetController@getDataPenempatan')->name('asset_penempatan/getDataPenempatan.getDataPenempatan');
    Route::post('asset_penempatan/store', 'AssetList\PenempatanAssetController@store')->name('asset_penempatan/store.store');

    Route::resource('asset_perusahaan', 'AssetList\PerusahaanAssetController')->except(['show']);
    Route::get('/asset_perusahaan/action_asset', 'AssetList\PerusahaanAssetController@actionAsset')->name('asset_perusahaan/action_asset.actionAsset');
    Route::get('/asset_perusahaan/action_penempatan', 'AssetList\PerusahaanAssetController@actionPenempatan')->name('asset_perusahaan/action_penempatan.actionPenempatan');
    Route::get('/asset_perusahaan/action_pemegang', 'AssetList\PerusahaanAssetController@actionPemegang')->name('asset_perusahaan/action_pemegang.actionPemegang');
    Route::get('asset_perusahaan/getDataListAsset', 'AssetList\PerusahaanAssetController@getDataListAsset')->name('asset_perusahaan/getDataListAsset.getDataListAsset');

    Route::resource('asset_dashboard', 'AssetList\DashboardAssetController')->except(['show']);
    Route::get('/asset_dashboard/getDataTotalAsset', 'AssetList\DashboardAssetController@getDataTotalAsset')->name('asset_dashboard/getDataTotalAsset.getDataTotalAsset');
    Route::get('/asset_dashboard/getDataTotalChart', 'AssetList\DashboardAssetController@getDataTotalChart')->name('asset_dashboard/getDataTotalChart.getDataTotalChart');
    Route::get('/asset_dashboard/getDataTotalDepoChart', 'AssetList\DashboardAssetController@getDataTotalDepoChart')->name('asset_dashboard/getDataTotalDepoChart.getDataTotalDepoChart');
    /**End Master Data List Asset */

    /**Master Data Pettu Cash */
    Route::resource('petty_cash', 'petty_cash\PettyCashController')->except(['show']);
    Route::get('petty_cash/update/{id}', 'petty_cash\PettyCashController@update_view')->name('petty_cash/update.update_view');
    Route::post('petty_cash/edit', 'petty_cash\PettyCashController@edit')->name('petty_cash/edit.edit');
    /**End Master Data Budget ATK */

    /** ######## Rekon ######## */
    Route::resource('rekening', 'RekeningController');
    Route::get('/ajax_depo_rekening', 'RekeningController@ajax_depo_rekening');
    Route::resource('bank', 'Rekon\BankController')->except(['create', 'show']);
    Route::resource('virtualaccount', 'Rekon\VirtualaccountController');
    Route::get('/ajax_depo_va', 'Rekon\VirtualaccountController@ajax_depo_va');
    Route::get('/ajax_rekening_bank', 'Rekon\VirtualaccountController@ajax_rekening_bank');
    Route::get('/ajax_rekening_bank_depo', 'Rekon\VirtualaccountController@ajax_rekening_bank_depo');
    Route::resource('master_selisih', 'Rekon\SelisihController');
    Route::resource('catatanrekening', 'Rekon\CatatanRekeningController')->except(['create', 'show']);
    Route::post('/catatanrekening/index', 'Rekon\CatatanRekeningController@storeData')->name('catatanrekening.storeData');
    Route::resource('mutasirekening', 'Rekon\MutasiRekeningController')->except(['create', 'show']);

    Route::resource('kredit', 'Rekon\KreditController')->except(['show']);
    //Route::resource('kredit', 'Rekon\KreditController')->except(['create','show']);
    Route::post('kredit/cari', 'Rekon\KreditController@rekeningcari')->name('kredit.rekeningcari');
    Route::get('/ajax_depo_dms', 'Rekon\KreditController@ajax_depo_dms');
    Route::get('/ajax_depo_bank', 'Rekon\KreditController@ajax_depo_bank');
    Route::get('/ajax_rekening_bank', 'Rekon\KreditController@ajax_rekening_bank');
    Route::get('/ajax_rekening_bank_depo', 'Rekon\KreditController@ajax_rekening_bank_depo');
    Route::get('/ajax_rekening_va', 'Rekon\KreditController@ajax_rekening_va');
    Route::post('kredit/store', 'Rekon\KreditController@store')->name('kredit/store.store');

    Route::resource('tagihan_tunai', 'Rekon\TagihanController')->except(['create', 'show']);
    Route::get('tagihan_tunai/cari_dms', 'Rekon\TagihanController@dmscari')->name('tagihan_tunai.dmscari');
    Route::get('/ajax_depo_dms', 'Rekon\TagihanController@ajax_depo_dms');
    Route::get('/ajax_depo_bank', 'Rekon\TagihanController@ajax_depo_bank');
    Route::get('/ajax_rekening_bank', 'Rekon\TagihanController@ajax_rekening_bank');
    Route::get('/ajax_rekening_bank_depo', 'Rekon\TagihanController@ajax_rekening_bank_depo');
    Route::get('/ajax_rekening_va', 'Rekon\TagihanController@ajax_rekening_va');
    Route::post('tagihan_tunai/store', 'Rekon\TagihanController@store')->name('tagihan_tunai/store.store');

    Route::resource('penjualan_tunai', 'Rekon\PenjualanController')->except(['create', 'show']);
    Route::get('penjualan_tunai/cari', 'Rekon\PenjualanController@cari')->name('penjualan_tunai.cari');
    Route::get('/ajax_depo_dms', 'Rekon\PenjualanController@ajax_depo_dms');
    Route::get('/ajax_depo_bank', 'Rekon\PenjualanController@ajax_depo_bank');
    Route::get('/ajax_rekening_bank', 'Rekon\PenjualanController@ajax_rekening_bank');
    Route::get('/ajax_rekening_bank_depo', 'Rekon\PenjualanController@ajax_rekening_bank_depo');
    Route::get('/ajax_rekening_va', 'Rekon\PenjualanController@ajax_rekening_va');

    Route::resource('tunai_transfer', 'Rekon\TunaiTransferController')->except(['create', 'show']);
    Route::get('tunai_transfer/cari', 'Rekon\TunaiTransferController@cari')->name('tunai_transfer.cari');
    Route::get('/ajax_depo_dms', 'Rekon\TunaiTransferController@ajax_depo_dms');
    Route::get('/ajax_depo_bank', 'Rekon\TunaiTransferController@ajax_depo_bank');
    Route::get('/ajax_rekening_bank', 'Rekon\TunaiTransferController@ajax_rekening_bank');
    Route::get('/ajax_rekening_bank_depo', 'Rekon\TunaiTransferController@ajax_rekening_bank_depo');

    Route::resource('kredit_info', 'Rekon\KreditInfoController')->except(['show']);

    Route::resource('tagihan_tunai_info', 'Rekon\TagihanInfoController')->except(['show']);

    Route::resource('penjualan_tunai_info', 'Rekon\PenjualanInfoController')->except(['show']);

    Route::resource('rekon_pelunasan', 'Rekon\RekonPelunasanController')->except(['show']);
    Route::get('rekon_pelunasan/dataPelunasanPiutang', 'Rekon\RekonPelunasanController@dataPelunasanPiutang')->name('rekon_pelunasan/dataPelunasanPiutang.dataPelunasanPiutang');
    Route::get('rekon_pelunasan/dataPelunasanKasir', 'Rekon\RekonPelunasanController@dataPelunasanKasir')->name('rekon_pelunasan/dataPelunasanKasir.dataPelunasanKasir');
    Route::get('rekon_pelunasan/dataPelunasanRekening', 'Rekon\RekonPelunasanController@dataPelunasanRekening')->name('rekon_pelunasan/dataPelunasanRekening.dataPelunasanRekening');
    Route::get('rekon_pelunasan/cari_piutang', 'Rekon\RekonPelunasanController@cari_piutang')->name('rekon_pelunasan/cari_piutang.cari_piutang');
    Route::get('rekon_pelunasan/cari_kasir', 'Rekon\RekonPelunasanController@cari_kasir')->name('rekon_pelunasan/cari_kasir.cari_kasir');
    Route::get('rekon_pelunasan/cari_rekening', 'Rekon\RekonPelunasanController@cari_rekening')->name('rekon_pelunasan/cari_rekening.cari_rekening');
    Route::get('rekon_pelunasan/getDmsInvoice', 'Rekon\RekonPelunasanController@getDmsInvoice')->name('rekon_pelunasan/getDmsInvoice.getDmsInvoice');
    Route::post('rekon_pelunasan/approval', 'Rekon\RekonPelunasanController@approval')->name('rekon_pelunasan/approval.approval');

    Route::resource('saldo', 'Rekon\SaldoController')->except(['create', 'show']);
    Route::get('saldo/cari', 'Rekon\SaldoController@cari')->name('saldo/cari.cari');
    Route::get('/ajax_depo', 'Rekon\SaldoController@ajax_depo');
    Route::get('/ajax_norek', 'Rekon\SaldoController@ajax_norek');
    Route::post('/konversi_data', 'Rekon\SaldoController@storeData')->name('konversi_data.storeData');

    Route::resource('monitoring', 'Rekon\MonitoringController')->except(['create', 'show']);
    Route::get('monitoring/cari', 'Rekon\MonitoringController@index_cari')->name('monitoring/cari.index_cari');
    Route::get('/ajax_depo', 'Rekon\MonitoringController@ajax_depo');

    /** ######## Rekon Opening Closing Saldo ######## */
    Route::resource('saldo_penjualan_tunai_ta', 'Saldo\SaldoPenjualanTunaiController')->except(['create', 'show']);
    Route::resource('saldo_tagihan_tunai_ta', 'Saldo\SaldoTagihanTunaiController')->except(['create', 'show']);
    Route::resource('saldo_tagihan_kredit_ta', 'Saldo\SaldoTagihanKreditController')->except(['create', 'show']);
    Route::resource('saldo_rekening_master_ta', 'Saldo\SaldoRekeningMasterController')->except(['create', 'show']);

    Route::resource('saldo_penjualan_tunai_tu', 'Saldo\SaldoPenjualanTunaiController')->except(['create', 'show']);
    Route::resource('saldo_tagihan_tunai_tu', 'Saldo\SaldoTagihanTunaiController')->except(['create', 'show']);
    Route::resource('saldo_tagihan_kredit_tu', 'Saldo\SaldoTagihanKreditController')->except(['create', 'show']);
    Route::resource('saldo_rekening_master_tu', 'Saldo\SaldoRekeningMasterController')->except(['create', 'show']);

    Route::resource('saldo_penjualan_tunai_tua', 'Saldo\SaldoPenjualanTunaiController')->except(['create', 'show']);
    Route::resource('saldo_tagihan_tunai_tua', 'Saldo\SaldoTagihanTunaiController')->except(['create', 'show']);
    Route::resource('saldo_tagihan_kredit_tua', 'Saldo\SaldoTagihanKreditController')->except(['create', 'show']);
    Route::resource('saldo_rekening_master_tua', 'Saldo\SaldoRekeningMasterController')->except(['create', 'show']);

    Route::resource('opening_closing_rek', 'Saldo\OpeningClosingRekController')->except(['create', 'show']);

    /** ######## Piutang ######## */
    Route::resource('pelunasan', 'Piutang\PelunasanController')->except(['show']);
    Route::get('/pelunasan/action_rek', 'Piutang\PelunasanController@actionRekening')->name('pelunasan/action_rek.actionRekening');
    Route::get('/pelunasan/get_dms', 'Piutang\PelunasanController@getDms')->name('getDms');
    Route::get('/pelunasan/get_invoice', 'Piutang\PelunasanController@getDmsInvoice')->name('getDmsInvoice');
    Route::get('pelunasan/cari', 'Piutang\PelunasanController@cari')->name('pelunasan/cari.cari');
    Route::post('pelunasan/store', 'Piutang\PelunasanController@store')->name('pelunasan/store.store');
    Route::post('pelunasan/kirim', 'Piutang\PelunasanController@kirim')->name('pelunasan/kirim.kirim');
    Route::get('pelunasan/view', 'Piutang\PelunasanController@view')->name('pelunasan/view.view');
    Route::get('pelunasan/cari_view', 'Piutang\PelunasanController@cari_view')->name('pelunasan/cari_view.cari_view');

    Route::get('pelunasan/getDetailDataPayment', 'Piutang\PelunasanController@getDetailDataPayment')->name('getDetailDataPayment');

    /** ######## Piutang Settlement ######## */
    Route::resource('piutang_settlement', 'Piutang\SettlementController')->except(['show']);

    /** ######## Finance ######## */
    Route::resource('category_fin', 'Finance\KategoriBukuController');
    Route::resource('sub_category_fin', 'Finance\SubKategoriBukuController');
    Route::resource('type', 'Finance\TypeController')->except(['create', 'show']);
    Route::resource('sub_type', 'Finance\TypeSubController')->except(['create', 'show']);
    Route::resource('bank_fin', 'Finance\BankFinController')->except(['create', 'show']);

    Route::resource('rekening_fin', 'Finance\RekeningFinController')->except(['show']);
    Route::get('rekening_fin/action_vendor', 'Finance\RekeningFinController@actionVendor')->name('rekening_fin/action_vendor.actionVendor');
    Route::get('rekening_fin/action_vendor_sp', 'Finance\RekeningFinController@actionVendorSp')->name('rekening_fin/action_vendor_sp.actionVendorSp');
    Route::resource('rekening_fin_index', 'Finance\ImportRekeningFinController')->except(['show']);
    Route::post('rekening_fin_index/import', 'Finance\ImportRekeningFinController@storeDataRekening')->name('rekening_fin_index/import.storeDataRekening');
    Route::get('rekening_fin/{kode_vendor}', 'Finance\RekeningFinController@edit')->name('rekening_fin.edit');
    Route::post('rekening_fin/update', 'Finance\RekeningFinController@update')->name('rekening_fin.update');

    Route::resource('rekening_fin_comp', 'Finance\RekeningFinCompController');
    Route::resource('vendor_fin', 'Finance\VendorController')->except(['show']);
    Route::get('vendor_fin/{kode_vendor}', 'Finance\VendorController@edit')->name('vendor_fin.edit');
    Route::post('vendor_fin/update', 'Finance\VendorController@update')->name('vendor_fin.update');
    Route::resource('vendor_fin_import', 'Finance\ImportVendorController')->except(['show']);
    Route::post('/vendor_fin_import/index', 'Finance\ImportVendorController@storeDataVendor')->name('vendor_fin_import.storeDataVendor');

    Route::resource('import_account', 'Finance\CatatanRekeningFinController')->except(['create', 'show']);
    Route::post('/import_account/index', 'Finance\CatatanRekeningFinController@storeData')->name('import_account.storeData');
    Route::resource('mutasirekening_fin', 'Finance\MutasiRekeningFinController')->except(['create', 'show']);
    Route::resource('pendaftaran_cek_giro', 'Finance\PendaftaranController')->except(['show']);
    Route::get('/pendaftaran_cek_giro/cari', 'Finance\PendaftaranController@cari')->name('pendaftaran_cek_giro/cari.cari');
    Route::get('/pendaftaran_cek_giro/cari_tanggal', 'Finance\PendaftaranController@cari_tanggal')->name('pendaftaran_cek_giro/cari_tanggal.cari_tanggal');
    Route::get('/pendaftaran_cek_giro/action', 'Finance\PendaftaranController@action')->name('pendaftaran_cek_giro.action');
    Route::get('/pendaftaran_cek_giro/action_rek', 'Finance\PendaftaranController@actionRekening')->name('pendaftaran_cek_giro.actionRekening');
    Route::get('/pendaftaran_cek_giro/action_cat', 'Finance\PendaftaranController@actionCategory')->name('pendaftaran_cek_giro.actionCategory');
    Route::get('pendaftaran/{no_urut}', 'Finance\PendaftaranController@view')->name('pendaftaran.view');

    Route::resource('pengisian_cek_giro', 'Finance\PengisianController')->except(['show']);
    Route::get('/pengisian_cekgiro/action_spp', 'Finance\PengisianController@actionSpp')->name('pengisian_cekgiro.actionSpp');
    Route::get('/pengisian_cekgiro/action_cekgiro', 'Finance\PengisianController@actionCekgiro')->name('pengisian_cekgiro.actionCekgiro');
    Route::get('/ajax_cat', 'Finance\PengisianController@ajax_cat');
    Route::post('/ajax/store', 'Finance\PengisianController@store')->name('store.store');
    Route::get('pengisian_cekgiro/cari', 'Finance\PengisianController@cari')->name('pengisian_cekgiro/cari.cari');

    Route::resource('spp_import', 'Finance\ImportSppController')->except(['show']);
    Route::post('/spp_import_head/index', 'Finance\ImportSppController@storeDataHead')->name('spp_import_head.storeDataHead');
    Route::post('/spp_import_detail/index', 'Finance\ImportSppController@storeDataDetail')->name('spp_import_detail.storeDataDetail');
    Route::resource('spp', 'Finance\SppController')->except(['show']);
    Route::get('spp/cari', 'Finance\SppController@cari')->name('spp/cari.cari');
    Route::get('/spp/action_kontra', 'Finance\SppController@actionKontra')->name('spp/action_kontra.actionKontra');
    Route::get('/spp/action_vendor', 'Finance\SppController@actionVendor')->name('spp/action_vendor.actionVendor');
    Route::get('/spp/action_payment', 'Finance\SppController@actionPayment')->name('spp/action_payment.actionPayment');
    Route::get('/spp/action_request', 'Finance\SppController@actionRequest')->name('spp/action_request.actionRequest');
    Route::get('/spp/action_sparepart', 'Finance\SppController@actionSparepart')->name('spp/action_sparepart.actionSparepart'); //jika menggunakan import rcm
    Route::get('/spp/action_sparepart_kontra', 'Finance\SppController@actionSparepartKontra')->name('spp/action_sparepart_kontra.actionSparepartKontra'); //jika tidak menggunakan import rcm
    Route::get('spp/view/{no_urut}', 'Finance\SppController@view')->name('spp/view.view');
    Route::get('spp/pdf/{no_urut}', 'Finance\SppController@pdf')->name('spp.spp_pdf');
    Route::get('spp/view_excel', 'Finance\SppController@view_excel')->name('spp/view_excel.view_excel');

    Route::resource('spp_group', 'Finance\SppGroupController')->except(['show']);
    Route::get('spp_group/action_vendor', 'Finance\SppGroupController@actionVendor')->name('spp_group/action_vendor.actionVendor');
    Route::post('spp_group/store', 'Finance\SppGroupController@store')->name('spp_group/store.store');
    Route::get('spp_group/pdf/{no_group}', 'Finance\SppGroupController@pdf')->name('spp_group/pdf.pdf');

    Route::resource('list_spp', 'Finance\SppListController')->except(['show']);
    Route::get('list_spp/cari', 'Finance\SppListController@cari')->name('list_spp/cari.cari');
    Route::get('list_spp/getDataSppTerima', 'Finance\SppListController@getDataSppTerima')->name('list_spp/getDataSppTerima');
    Route::get('list_spp/getDataDetail', 'Finance\SppListController@getDataDetail')->name('list_spp/getDataDetail');
    Route::get('list_spp/getDataSpp', 'Finance\SppListController@getDataSpp')->name('list_spp/getDataSpp');
    Route::get('list_spp/getDataLampiran', 'Finance\SppListController@getDataLampiran')->name('list_spp/getDataLampiran');
    Route::get('list_spp/getDataLampiranManual', 'Finance\SppListController@getDataLampiranManual')->name('list_spp/getDataLampiranManual');
    Route::post('list_spp/store', 'Finance\SppListController@store')->name('list_spp/store');
    Route::get('list_spp/pdf_spp/{no_urut}', 'Finance\SppListController@pdf_spp')->name('list_spp/pdf_spp.pdf_spp');
    Route::get('list_spp/pdf_pengajuan/{no_urut_pengajuan}', 'Finance\SppListController@pdf_pengajuan')->name('list_spp/pdf_pengajuan.pdf_pengajuan');
    Route::get('list_spp/pdf_pengajuan_biaya/{no_urut_pengajuan}', 'Finance\SppListController@pdf_pengajuan_biaya')->name('list_spp/pdf_pengajuan_biaya.pdf_pengajuan_biaya');
    // Route::get('rekening_outlet/getDataRekening','Snd\RekeningOutletController@getDataRekening')->name('rekening_outlet/getDataRekening.getDataRekening');
    // Route::get('/ajax_depo_rekening', 'Snd\RekeningOutletController@ajax_depo_rekening');
    // Route::post('rekening_outlet/store','Snd\RekeningOutletController@store')->name('rekening_outlet/store.store');
    // Route::get('rekening_outlet/getDataRekeningDetail','Snd\RekeningOutletController@getDataRekeningDetail')->name('rekening_outlet/getDataRekeningDetail.getDataRekeningDetail');
    // Route::post('rekening_outlet/update','Snd\RekeningOutletController@update')->name('rekening_outlet/update.update');

    Route::resource('tanda_terima', 'Finance\TandaTerimaController')->except(['show']);
    Route::get('tanda_terima/pdf/{receipt_id}', 'Finance\TandaTerimaController@pdf')->name('tanda_terima/pdf.pdf');
    Route::get('/tanda_terima/action_cekgiro', 'Finance\TandaTerimaController@actionCekgiro')->name('tanda_terima/action_cekgiro.actionCekgiro');
    Route::get('tanda_terima/action_cek', 'Finance\TandaTerimaController@actionCek')->name('tanda_terima/action_cek.actionCek');
    Route::get('tanda_terima/action_modal_cek', 'Finance\TandaTerimaController@actionModalCek')->name('tanda_terima/action_modal_cek.actionModalCek');
    Route::get('tanda_terima/{receipt_id}', 'Finance\TandaTerimaController@view')->name('tanda_terima.view');
    Route::post('tanda_terima-approved', 'Finance\TandaTerimaController@approved')->name('tanda_terima-approved');

    Route::resource('tanda_terima_a', 'Finance\TandaTerima_A_Controller')->except(['show']);
    Route::get('tanda_terima_a/pdf/{receipt_id}', 'Finance\TandaTerima_A_Controller@pdf')->name('tanda_terima_a/pdf.pdf');
    Route::get('tanda_terima_a/action_cekgiro', 'Finance\TandaTerima_A_Controller@actionCekgiro')->name('tanda_terima_a/action_cekgiro.actionCekgiro');
    Route::get('tanda_terima_a/action_cek', 'Finance\TandaTerima_A_Controller@actionCek')->name('tanda_terima_a/action_cek.actionCek');
    Route::get('tanda_terima_a/{receipt_id}', 'Finance\TandaTerima_A_Controller@view')->name('tanda_terima_a.view');
    Route::post('tanda_terima_a-approved', 'Finance\TandaTerima_A_Controller@approved')->name('tanda_terima_a-approved');

    Route::resource('tanda_terima_b', 'Finance\TandaTerima_B_Controller')->except(['show']);
    Route::get('/ajax_seri_warkat', 'Finance\TandaTerima_B_Controller@ajax_seri_warkat');
    Route::get('/ajax_perusahaan_bank', 'Finance\TandaTerima_B_Controller@ajax_perusahaan_bank');
    Route::get('/ajax_perusahaan_bank_rekening', 'Finance\TandaTerima_B_Controller@ajax_perusahaan_bank_rekening');
    Route::get('tanda_terima_b/action_vendor', 'Finance\TandaTerima_B_Controller@actionVendor')->name('tanda_terima_b/action_vendor.actionVendor');
    Route::get('tanda_terima_b/action_pembayar', 'Finance\TandaTerima_B_Controller@actionPembayar')->name('tanda_terima_b/action_pembayar.actionPembayar');
    Route::get('tanda_terima_b/action_seri_awal', 'Finance\TandaTerima_B_Controller@action_seri_awal')->name('tanda_terima_b/action_seri_awal.action_seri_awal');
    Route::get('tanda_terima_b/action_seri_akhir', 'Finance\TandaTerima_B_Controller@action_seri_akhir')->name('tanda_terima_b/action_seri_akhir.action_seri_akhir');
    Route::get('/tanda_terima_b/getDataIzinB', 'Finance\TandaTerima_B_Controller@getDataIzinB')->name('tanda_terima_b.getDataIzinB');
    Route::get('/tanda_terima_b/cari', 'Finance\TandaTerima_B_Controller@cari')->name('tanda_terima_b/cari.cari');
    Route::get('/tanda_terima_b/getViewDetail', 'Finance\TandaTerima_B_Controller@getViewDetail')->name('tanda_terima_b/getViewDetail');
    Route::get('/tanda_terima_b/pdf/{no_urut}', 'Finance\TandaTerima_B_Controller@pdf')->name('tanda_terima_b/pdf');

    Route::resource('tanda_terima_d', 'Finance\TandaTerima_D_Controller')->except(['show']);
    Route::get('tanda_terima_d/pdf/{receipt_id}', 'Finance\TandaTerima_D_Controller@pdf')->name('tanda_terima_d/pdf.pdf');
    Route::get('tanda_terima_d/action_cekgiro', 'Finance\TandaTerima_D_Controller@actionCekgiro')->name('tanda_terima_d/action_cekgiro.actionCekgiro');
    Route::get('tanda_terima_d/{receipt_id}', 'Finance\TandaTerima_D_Controller@view')->name('tanda_terima_d.view');
    Route::post('tanda_terima_d-approved', 'Finance\TandaTerima_D_Controller@approved')->name('tanda_terima_d-approved');

    Route::resource('tanda_terima_e', 'Finance\TandaTerima_E_Controller')->except(['show']);
    Route::get('tanda_terima_e/action_seri_awal', 'Finance\TandaTerima_E_Controller@action_seri_awal')->name('tanda_terima_e/action_seri_awal.action_seri_awal');
    Route::get('tanda_terima_e/action_seri_akhir', 'Finance\TandaTerima_E_Controller@action_seri_akhir')->name('tanda_terima_e/action_seri_akhir.action_seri_akhir');
    Route::post('tanda_terima_e/ajax/store', 'Finance\TandaTerima_E_Controller@store')->name('tanda_terima_e/ajax/store.store');
    Route::get('tanda_terima_e/view/{no_urut}', 'Finance\TandaTerima_E_Controller@view')->name('tanda_terima_e.view');
    Route::post('tanda_terima_e/store_terima', 'Finance\TandaTerima_E_Controller@store_terima')->name('tanda_terima_e/store_terima.store_terima');
    Route::get('/tanda_terima_e/pdf/{no_urut}', 'Finance\TandaTerima_E_Controller@pdf')->name('tanda_terima_e/pdf');

    Route::resource('tanda_terima_f', 'Finance\TandaTerima_f_Controller')->except(['show']);
    Route::get('/ajax_seri_warkat', 'Finance\TandaTerima_f_Controller@ajax_seri_warkat');
    Route::get('/ajax_perusahaan_bank', 'Finance\TandaTerima_f_Controller@ajax_perusahaan_bank');
    Route::get('/ajax_perusahaan_bank_rekening', 'Finance\TandaTerima_f_Controller@ajax_perusahaan_bank_rekening');
    Route::get('tanda_terima_f/action_vendor', 'Finance\TandaTerima_f_Controller@actionVendor')->name('tanda_terima_f/action_vendor.actionVendor');
    Route::get('tanda_terima_f/action_seri_awal', 'Finance\TandaTerima_f_Controller@action_seri_awal')->name('tanda_terima_f/action_seri_awal.action_seri_awal');
    Route::get('tanda_terima_f/action_seri_akhir', 'Finance\TandaTerima_f_Controller@action_seri_akhir')->name('tanda_terima_f/action_seri_akhir.action_seri_akhir');
    Route::get('/tanda_terima_f/getDataIzinB', 'Finance\TandaTerima_f_Controller@getDataIzinB')->name('tanda_terima_f.getDataIzinB');
    Route::get('/tanda_terima_f/cari', 'Finance\TandaTerima_f_Controller@cari')->name('tanda_terima_f/cari.cari');
    Route::get('/tanda_terima_f/getViewDetail', 'Finance\TandaTerima_f_Controller@getViewDetail')->name('tanda_terima_f/getViewDetail');
    Route::get('/tanda_terima_f/pdf/{no_urut}', 'Finance\TandaTerima_f_Controller@pdf')->name('tanda_terima_f/pdf');

    Route::resource('tanda_terima_g', 'Finance\TandaTerima_g_Controller')->except(['show']);
    Route::get('/ajax_seri_warkat', 'Finance\TandaTerima_g_Controller@ajax_seri_warkat');
    Route::get('/ajax_perusahaan_bank', 'Finance\TandaTerima_g_Controller@ajax_perusahaan_bank');
    Route::get('/ajax_perusahaan_bank_rekening', 'Finance\TandaTerima_g_Controller@ajax_perusahaan_bank_rekening');
    Route::get('tanda_terima_g/action_vendor', 'Finance\TandaTerima_g_Controller@actionVendor')->name('tanda_terima_g/action_vendor.actionVendor');
    Route::get('/tanda_terima_g/getDataIzinB', 'Finance\TandaTerima_g_Controller@getDataIzinB')->name('tanda_terima_g.getDataIzinB');
    Route::get('/tanda_terima_g/view/{no_urut}', 'Finance\TandaTerima_g_Controller@view')->name('tanda_terima_g.view');
    Route::post('/tanda_terima_g/store_terima', 'Finance\TandaTerima_g_Controller@store_terima')->name('tanda_terima_g/store_terima.store_terima');
    Route::get('/tanda_terima_g/cari', 'Finance\TandaTerima_g_Controller@cari')->name('tanda_terima_g/cari.cari');
    Route::get('/tanda_terima_g/getViewDetail', 'Finance\TandaTerima_g_Controller@getViewDetail')->name('tanda_terima_g/getViewDetail');
    Route::get('/tanda_terima_g/pdf/{no_urut}', 'Finance\TandaTerima_g_Controller@pdf')->name('tanda_terima_g/pdf');

    Route::resource('tanda_terima_h', 'Finance\TandaTerima_H_Controller')->except(['show']);
    Route::get('/tanda_terima_h/action', 'Finance\TandaTerima_H_Controller@action')->name('tanda_terima_h.action');
    Route::get('/tanda_terima_h/action_rek', 'Finance\TandaTerima_H_Controller@actionRekening')->name('tanda_terima_h.actionRekening');
    Route::get('/tanda_terima_h/action_cat', 'Finance\TandaTerima_H_Controller@actionCategory')->name('tanda_terima_h.actionCategory');
    Route::get('/tanda_terima_h/getDataIzinH', 'Finance\TandaTerima_H_Controller@getDataIzinH')->name('tanda_terima_h.getDataIzinH');
    Route::get('/tanda_terima_h/cari', 'Finance\TandaTerima_H_Controller@cari')->name('tanda_terima_h/cari.cari');
    Route::get('/tanda_terima_h/getViewDetail', 'Finance\TandaTerima_H_Controller@getViewDetail')->name('tanda_terima_h/getViewDetail');
    Route::get('/tanda_terima_h/pdf', 'Finance\TandaTerima_H_Controller@pdf')->name('tanda_terima_h/pdf');
    Route::get('/tanda_terima_h/excel', 'Finance\TandaTerima_H_Controller@excel')->name('tanda_terima_h/excel');

    Route::resource('tanda_terima_i', 'Finance\TandaTerima_I_Controller')->except(['show']);
    Route::get('tanda_terima_i/pdf/{receipt_id}', 'Finance\TandaTerima_I_Controller@pdf')->name('tanda_terima_i/pdf.pdf');
    Route::get('tanda_terima_i/action_cekgiro', 'Finance\TandaTerima_I_Controller@actionCekgiro')->name('tanda_terima_i/action_cekgiro.actionCekgiro');
    Route::get('tanda_terima_i/{receipt_id}', 'Finance\TandaTerima_I_Controller@view')->name('tanda_terima_i.view');
    Route::post('tanda_terima_i-approved', 'Finance\TandaTerima_I_Controller@approved')->name('tanda_terima_i-approved');

    Route::resource('tanda_terima_j', 'Finance\TandaTerima_J_Controller')->except(['show']);
    Route::get('tanda_terima_j/pdf/{receipt_id}', 'Finance\TandaTerima_J_Controller@pdf')->name('tanda_terima_j/pdf.pdf');
    Route::get('tanda_terima_j/action_cekgiro', 'Finance\TandaTerima_J_Controller@actionCekgiro')->name('tanda_terima_j/action_cekgiro.actionCekgiro');
    Route::get('tanda_terima_j/{receipt_id}', 'Finance\TandaTerima_J_Controller@view')->name('tanda_terima_j.view');
    Route::post('tanda_terima_j-approved', 'Finance\TandaTerima_J_Controller@approved')->name('tanda_terima_j-approved');

    Route::resource('approval_a', 'Finance\Approval_A_Controller')->except(['show']);
    Route::get('approval_a/cari', 'Finance\Approval_A_Controller@cari')->name('approval_a/cari.cari');
    Route::get('approval_a/{receipt_id}', 'Finance\Approval_A_Controller@view')->name('approval_a.view');
    Route::post('approval_a-approved', 'Finance\Approval_A_Controller@approved')->name('approval_a-approved');
    Route::get('approval_a-pending/{receipt_id}', 'Finance\Approval_A_Controller@pending')->name('approval_a-pending');

    Route::resource('approval_b', 'Finance\Approval_B_Controller')->except(['show']);
    Route::get('approval_b/cari', 'Finance\Approval_B_Controller@cari')->name('approval_b/cari.cari');
    Route::get('approval_b/{receipt_id}', 'Finance\Approval_B_Controller@view')->name('approval_b.view');
    Route::post('approval_b-approved', 'Finance\Approval_B_Controller@approved')->name('approval_b-approved');
    Route::get('approval_b-pending/{receipt_id}', 'Finance\Approval_B_Controller@pending')->name('approval_b-pending');

    Route::resource('approval_c', 'Finance\Approval_C_Controller')->except(['show']);
    Route::get('approval_c/cari', 'Finance\Approval_C_Controller@cari')->name('approval_c/cari.cari');
    Route::get('approval_c/{receipt_id}', 'Finance\Approval_C_Controller@view')->name('approval_c.view');
    //Route::get('approval_c-approved/{receipt_id}', 'Finance\Approval_C_Controller@approved')->name('approval_c-approved');
    Route::post('approval_c-approved', 'Finance\Approval_C_Controller@approved')->name('approval_c-approved');
    Route::get('approval_c-pending/{receipt_id}', 'Finance\Approval_C_Controller@pending')->name('approval_c-pending');

    Route::resource('approval_d', 'Finance\Approval_D_Controller')->except(['show']);
    Route::get('approval_d/cari', 'Finance\Approval_D_Controller@cari')->name('approval_d/cari.cari');
    Route::get('approval_d/{receipt_id}', 'Finance\Approval_D_Controller@view')->name('approval_d.view');
    Route::post('approval_d-approved', 'Finance\Approval_D_Controller@approved')->name('approval_d-approved');
    Route::get('approval_d-pending/{receipt_id}', 'Finance\Approval_D_Controller@pending')->name('approval_d-pending');

    Route::resource('approval_e', 'Finance\Approval_E_Controller')->except(['show']);
    Route::get('approval_e/cari', 'Finance\Approval_E_Controller@cari')->name('approval_e/cari.cari');
    Route::get('approval_e/{receipt_id}', 'Finance\Approval_E_Controller@view')->name('approval_e.view');
    Route::post('approval_e-approved', 'Finance\Approval_E_Controller@approved')->name('approval_e-approved');
    Route::get('approval_e-pending/{receipt_id}', 'Finance\Approval_E_Controller@pending')->name('approval_e-pending');

    Route::resource('approval_f', 'Finance\Approval_F_Controller')->except(['show']);
    Route::get('approval_f/cari', 'Finance\Approval_F_Controller@cari')->name('approval_f/cari.cari');
    Route::get('approval_f/{receipt_id}', 'Finance\Approval_F_Controller@view')->name('approval_f.view');
    Route::post('approval_f-approved', 'Finance\Approval_F_Controller@approved')->name('approval_f-approved');
    Route::get('approval_f-pending/{receipt_id}', 'Finance\Approval_F_Controller@pending')->name('approval_f-pending');

    Route::resource('approval_g', 'Finance\Approval_G_Controller')->except(['show']);
    Route::get('approval_g/cari', 'Finance\Approval_G_Controller@cari')->name('approval_g/cari.cari');
    Route::get('approval_g/{receipt_id}', 'Finance\Approval_G_Controller@view')->name('approval_g.view');
    Route::post('approval_g-approved', 'Finance\Approval_G_Controller@approved')->name('approval_g-approved');
    Route::get('approval_g-pending/{receipt_id}', 'Finance\Approval_G_Controller@pending')->name('approval_g-pending');

    Route::resource('approval_h', 'Finance\Approval_H_Controller')->except(['show']);
    Route::get('/approval_h/getDataIzinH', 'Finance\Approval_H_Controller@getDataIzinH')->name('approval_h.getDataIzinH');
    Route::get('/approval_h/cari', 'Finance\Approval_H_Controller@cari')->name('approval_h/cari.cari');
    Route::get('/approval_h/getViewDetail', 'Finance\Approval_H_Controller@getViewDetail')->name('approval_h/getViewDetail');
    Route::get('/approval_h/pdf', 'Finance\Approval_H_Controller@pdf')->name('approval_h/pdf');
    Route::post('/approval_h/approved', 'Finance\Approval_H_Controller@approved')->name('approval_h/approved');

    Route::resource('transfer_program_claim', 'Finance\TransferProgramClaim')->except(['show']);
    Route::get('/transfer_program_claim/getData', 'Finance\TransferProgramClaim@getData')->name('transfer_program_claim.getData');
    Route::get('/transfer_program_claim/{no_urut}', 'Finance\TransferProgramClaim@showView')->name('transfer_program_claim');
    Route::post('/transfer_program_claim/transfer', 'Finance\TransferProgramClaim@transfer')->name('transfer_program_claim/transfer.transfer');
    Route::post('/transfer_program_claim/transfer_ng', 'Finance\TransferProgramClaim@transfer_ng')->name('transfer_program_claim/transfer_ng.transfer_ng');
    Route::post('/transfer_program_claim/transfer_depo', 'Finance\TransferProgramClaim@transfer_depo')->name('transfer_program_claim/transfer_depo.transfer_depo');
    Route::post('/transfer_program_claim/transfer_all', 'Finance\TransferProgramClaim@transfer_all')->name('transfer_program_claim/transfer_all.transfer_all');
    Route::get('transfer_program_claim/excel/{no_urut}', 'Finance\TransferProgramClaim@excel')->name('transfer_program_claim.excel');
    Route::get('transfer_program_claim/excel_bulk/{no_urut}', 'Finance\TransferProgramClaim@excel_bulk')->name('transfer_program_claim.excel_bulk');

    Route::resource('transfer_program_claim_his', 'Finance\TransferProgramClaimHis')->except(['show']);
    Route::get('/transfer_program_claim_his/getData', 'Finance\TransferProgramClaimHis@getData')->name('transfer_program_claim_his.getData');
    Route::get('/transfer_program_claim_his/cari', 'Finance\TransferProgramClaimHis@cari')->name('transfer_program_claim_his/cari.cari');
    Route::get('/transfer_program_claim_his/{no_urut}', 'Finance\TransferProgramClaimHis@showView')->name('transfer_program_claim_his');

    Route::resource('pengajuan_cek_giro', 'Finance\PengajuanCekGiroController')->except(['show']);
    Route::get('pengajuan_cek_giro/action_rek', 'Finance\PengajuanCekGiroController@actionRek')->name('pengajuan_cek_giro/action_rek.actionRek');
    Route::get('pengajuan_cek_giro/action_cekgiro', 'Finance\PengajuanCekGiroController@actionCekgiro')->name('pengajuan_cek_giro/action_cekgiro.actionCekgiro');
    Route::get('pengajuan_cek_giro/cari', 'Finance\PengajuanCekGiroController@cari')->name('pengajuan_cek_giro/cari.cari');
    Route::get('pengajuan_cek_giro/{kode_pengajuan}', 'Finance\PengajuanCekGiroController@view')->name('pengajuan_cek_giro.view');
    Route::post('/ajax/store', 'Finance\PengajuanCekGiroController@store')->name('store.store');
    Route::post('/ajax/store_terima', 'Finance\PengajuanCekGiroController@store_terima')->name('store_terima.store_terima');
    Route::get('pengajuan_cek_giro/pdf/{kode_pengajuan}', 'Finance\PengajuanCekGiroController@pdf')->name('pengajuan_cek_giro/pdf');
    Route::get('pengajuan_cek_giro/excel/{kode_pengajuan}', 'Finance\PengajuanCekGiroController@excel')->name('pengajuan_cek_giro/excel');
    Route::get('/cek-izin', 'Finance\PengajuanCekGiroController@cekIzin')->name('cek_izin');


    Route::resource('monitoring_cek', 'Finance\MonitoringCekController')->except(['show']);

    Route::resource('report_cekgiro', 'Finance\ReportCekGiroController')->except(['show']);
    Route::get('report_cekgiro/cari', 'Finance\ReportCekGiroController@cari')->name('report_cekgiro/cari.cari');

    Route::resource('report_permission', 'Finance\ReportPermissionController')->except(['show']);
    Route::get('report_permission/cari', 'Finance\ReportPermissionController@cari')->name('report_permission/cari.cari');

    /** ######## pengajuan ######## */
    Route::resource('pengajuan', 'Pengajuan\PengajuanController')->except(['show']);
    Route::get('pengajuan/cari', 'Pengajuan\PengajuanController@cari')->name('pengajuan/cari.cari');
    Route::get('/pengajuan/action_approved', 'Pengajuan\PengajuanController@actionApproved')->name('pengajuan/action_approved.actionApproved');
    Route::get('/pengajuan/action_category', 'Pengajuan\PengajuanController@actionCategory')->name('pengajuan/action_category.actionCategory');
    Route::get('/pengajuan/action_product', 'Pengajuan\PengajuanController@actionProduct')->name('pengajuan/action_product.actionProduct');
    Route::get('/pengajuan/actionProduct_tgsm', 'Pengajuan\PengajuanController@actionProduct_tgsm')->name('pengajuan/action_product.actionProduct_tgsm');
    Route::get('pengajuan/{kode_pengajuan}', 'Pengajuan\PengajuanController@view')->name('pengajuan.view');
    Route::get('pengajuan/update/{kode_pengajuan}', 'Pengajuan\PengajuanController@update')->name('pengajuan/update.update');
    Route::post('pengajuan/edit', 'Pengajuan\PengajuanController@edit')->name('pengajuan/edit.edit');
    Route::get('pengajuan/view_approval/{kode_pengajuan}', 'Pengajuan\PengajuanController@view_approval')->name('pengajuan/view_approval.view');
    Route::get('pengajuan/pdf/{no_urut}', 'Pengajuan\PengajuanController@pdf')->name('pengajuan/pdf.pdf');
    Route::get('pengajuan/download/{filename}', 'Pengajuan\PengajuanController@download')->name('pengajuan/download.download');

    Route::resource('pengajuan_masuk', 'Pengajuan\PengajuanMasukController')->except(['show']);
    Route::get('pengajuan_masuk/cari', 'Pengajuan\PengajuanMasukController@cari')->name('pengajuan_masuk/cari.cari');
    Route::get('pengajuan_masuk/view/{kode_pengajuan}', 'Pengajuan\PengajuanMasukController@view')->name('pengajuan_masuk/view.view');
    Route::post('pengajuan_masuk/view/Approved', 'Pengajuan\PengajuanMasukController@approved')->name('pengajuan_masuk/view/Approved.approved');
    Route::post('pengajuan_masuk/view/pending', 'Pengajuan\PengajuanMasukController@pending')->name('pengajuan_masuk/view/pending.pending');
    Route::get('pengajuan_masuk/pdf/{no_urut}', 'Pengajuan\PengajuanMasukController@pdf')->name('pengajuan_masuk/pdf.pdf');

    Route::resource('pengajuan_biaya', 'Pengajuan\PengajuanBiayaController')->except(['show']);
    Route::get('pengajuan_biaya/cari', 'Pengajuan\PengajuanBiayaController@cari')->name('pengajuan_biaya/cari.cari');
    Route::get('pengajuan_biaya/action_category', 'Pengajuan\PengajuanBiayaController@actionCategory')->name('pengajuan_biaya/action_category.actionCategory');
    Route::get('pengajuan_biaya/action_coa', 'Pengajuan\PengajuanBiayaController@actionCoa')->name('pengajuan_biaya/action_coa.actionCoa');
    Route::get('pengajuan_biaya/{no_urut}', 'Pengajuan\PengajuanBiayaController@view')->name('pengajuan_biaya.view');
    Route::get('pengajuan_biaya/update/{no_urut}', 'Pengajuan\PengajuanBiayaController@update')->name('pengajuan_biaya/update.update');
    Route::post('pengajuan_biaya/edit', 'Pengajuan\PengajuanBiayaController@edit')->name('pengajuan_biaya/edit.edit');
    Route::get('pengajuan_biaya/view_approval/{no_urut}', 'Pengajuan\PengajuanBiayaController@view_approval')->name('pengajuan_biaya/view_approval.view_approval');
    Route::get('pengajuan_biaya/pdf/{no_urut}', 'Pengajuan\PengajuanBiayaController@pdf')->name('pengajuan_biaya/pdf.pdf');
    Route::get('pengajuan_biaya/pdf_new/{no_urut}', 'Pengajuan\PengajuanBiayaController@pdf_new')->name('pengajuan_biaya/pdf_new.pdf_new');
    Route::get('/ajax', 'Pengajuan\PengajuanBiayaController@ajax');

    Route::resource('pengajuan_biaya_masuk', 'Pengajuan\PengajuanBiayaMasukController')->except(['show']);
    Route::get('pengajuan_biaya_masuk/cari', 'Pengajuan\PengajuanBiayaMasukController@cari')->name('pengajuan_biaya_masuk/cari.cari');
    Route::get('pengajuan_biaya_masuk/view/{no_urut}', 'Pengajuan\PengajuanBiayaMasukController@view')->name('pengajuan_biaya_masuk/view.view');
    //Route::post('pengajuan_biaya_masuk/view/Approved', 'Pengajuan\PengajuanBiayaMasukController@approved')->name('pengajuan_biaya_masuk/view/Approved.approved');
    //Route::get('pengajuan_biaya_masuk/view/pending/{no_urut}', 'Pengajuan\PengajuanBiayaMasukController@pending')->name('pengajuan_biaya_masuk/view/pending.pending');
    Route::post('pengajuan_biaya_masuk/approved', 'Pengajuan\PengajuanBiayaMasukController@approved')->name('pengajuan_biaya_masuk/approved.approved');
    Route::post('pengajuan_biaya_masuk/pending', 'Pengajuan\PengajuanBiayaMasukController@pending')->name('pengajuan_biaya_masuk/pending.pending');
    Route::post('pengajuan_biaya_masuk/denied', 'Pengajuan\PengajuanBiayaMasukController@denied')->name('pengajuan_biaya_masuk/denied.denied');

    Route::resource('pengajuan_biaya_upload', 'Pengajuan\PengajuanUploadOtorisasi')->except(['show']);
    Route::get('pengajuan_biaya_upload/cari', 'Pengajuan\PengajuanUploadOtorisasi@cari')->name('pengajuan_biaya_upload/cari.cari');
    Route::get('pengajuan_biaya_upload/view/{no_urut}', 'Pengajuan\PengajuanUploadOtorisasi@view')->name('pengajuan_biaya_upload/view.view');
    Route::post('pengajuan_biaya_upload/upload', 'Pengajuan\PengajuanUploadOtorisasi@upload')->name('pengajuan_biaya_upload/upload.upload');

    Route::resource('pengajuan_biaya_bbm_sales', 'Pengajuan\PengajuanBiayaBbmSalesController')->except(['show']);
    Route::get('/pengajuan_biaya_bbm_sales/getDataBbm', 'Pengajuan\PengajuanBiayaBbmSalesController@getDataBbm')->name('pengajuan_biaya_bbm_sales.getDataBbm');
    Route::get('/pengajuan_biaya_bbm_sales/cari', 'Pengajuan\PengajuanBiayaBbmSalesController@cari')->name('pengajuan_biaya_bbm_sales.cari');

    Route::resource('pengajuan_b_bbm_sales_lnjtn', 'Pengajuan\PengajuanBiayaBbmSalesLanjutanController')->except(['show']);
    Route::get('pengajuan_b_bbm_sales_lnjtn/cari_index', 'Pengajuan\PengajuanBiayaBbmSalesLanjutanController@cari_index')->name('pengajuan_b_bbm_sales_lnjtn/cari_index.cari_index');
    Route::get('pengajuan_b_bbm_sales_lnjtn/view/{no_urut}', 'Pengajuan\PengajuanBiayaBbmSalesLanjutanController@view')->name('pengajuan_b_bbm_sales_lnjtn/view.view');
    Route::get('pengajuan_b_bbm_sales_lnjtn/cari', 'Pengajuan\PengajuanBiayaBbmSalesLanjutanController@cari')->name('pengajuan_b_bbm_sales_lnjtn/cari.cari');
    Route::post('pengajuan_b_bbm_sales_lnjtn/store', 'Pengajuan\PengajuanBiayaBbmSalesLanjutanController@store')->name('pengajuan_b_bbm_sales_lnjtn/store.store');

    Route::resource('pengajuan_biaya_masuk_bbm', 'Pengajuan\PengajuanBiayaMasukBbmSalesController')->except(['show']);
    Route::get('pengajuan_biaya_masuk_bbm/cari_index', 'Pengajuan\PengajuanBiayaMasukBbmSalesController@cari_index')->name('pengajuan_biaya_masuk_bbm/cari_index.cari_index');
    Route::get('pengajuan_biaya_masuk_bbm/view/{no_urut}', 'Pengajuan\PengajuanBiayaMasukBbmSalesController@view')->name('pengajuan_biaya_masuk_bbm/view.view');
    Route::post('pengajuan_biaya_masuk_bbm/approved', 'Pengajuan\PengajuanBiayaMasukBbmSalesController@approved')->name('pengajuan_biaya_masuk_bbm/approved.approved');

    Route::resource('pengajuan_vendor', 'Pengajuan\PengajuanVendorController')->except(['show']);
    Route::get('pengajuan_vendor/cari', 'Pengajuan\PengajuanVendorController@cari')->name('pengajuan_vendor/cari.cari');
    Route::get('pengajuan_vendor/{kode_pengajuan_v}', 'Pengajuan\PengajuanVendorController@view')->name('pengajuan_vendor.view');

    Route::resource('sppd', 'Pengajuan\SppdController')->except(['show']);
    Route::get('sppd/cari', 'Pengajuan\SppdController@cari')->name('sppd/cari.cari');
    Route::get('/ajax_depo_tujuan', 'Pengajuan\SppdController@ajax_depo_tujuan');
    Route::get('/sppd/action_category', 'Pengajuan\SppdController@actionCategory')->name('sppd/action_category.actionCategory');
    Route::get('sppd/view_approval/{kode_pengajuan_sppd}', 'Pengajuan\SppdController@view_approval')->name('sppd/view_approval.view_approval');
    Route::get('sppd/view/{kode_pengajuan}', 'Pengajuan\SppdController@view')->name('sppd/view.view');
    Route::get('sppd/pdf/{no_urut}', 'Pengajuan\SppdController@pdf')->name('sppd/pdf.pdf');

    Route::resource('sppd_masuk', 'Pengajuan\SppdMasukController')->except(['show']);
    Route::get('sppd_masuk/cari', 'Pengajuan\SppdMasukController@cari')->name('sppd_masuk/cari.cari');
    Route::get('sppd_masuk/view/{no_urut}', 'Pengajuan\SppdMasukController@view')->name('sppd_masuk/view.view');
    Route::post('sppd_masuk/approved', 'Pengajuan\SppdMasukController@approved')->name('sppd_masuk/approved.approved');

    Route::resource('pengajuan_tiv', 'Pengajuan\PengajuanTivController')->except(['show']);
    Route::get('pengajuan_tiv/cari', 'Pengajuan\PengajuanTivController@cari')->name('pengajuan_tiv/cari.cari');
    Route::get('pengajuan_tiv/action_category', 'Pengajuan\PengajuanTivController@actionCategory')->name('pengajuan_tiv/action_category.actionCategory');
    Route::get('pengajuan_tiv/action_program', 'Pengajuan\PengajuanTivController@actionProgram')->name('pengajuan_tiv/action_program.actionProgram');
    Route::get('pengajuan_tiv/action_rekening', 'Pengajuan\PengajuanTivController@actionRekening')->name('pengajuan_tiv/action_rekening.actionRekening');
    Route::get('pengajuan_tiv/cari_data', 'Pengajuan\PengajuanTivController@cari_data')->name('pengajuan_tiv/cari_data.cari_data');
    Route::get('pengajuan_tiv/cari_data_upload', 'Pengajuan\PengajuanTivController@cari_data_upload')->name('pengajuan_tiv/cari_data_upload.cari_data_upload');
    Route::get('pengajuan_tiv/cari_data_all', 'Pengajuan\PengajuanTivController@cari_data_all')->name('pengajuan_tiv/cari_data_all.cari_data_all');
    Route::get('pengajuan_tiv/view_data_all', 'Pengajuan\PengajuanTivController@view_data_all')->name('pengajuan_tiv/view_data_all.view_data_all');
    Route::get('pengajuan_tiv/action_tanggungan', 'Pengajuan\PengajuanTivController@actionTanggungan')->name('pengajuan_tiv/action_tanggungan.actionTanggungan');
    Route::get('pengajuan_tiv/{no_urut}', 'Pengajuan\PengajuanTivController@view')->name('pengajuan_tiv.view');
    Route::get('pengajuan_tiv/view_approval/{no_urut}', 'Pengajuan\PengajuanTivController@view_approval')->name('pengajuan_tiv/view_approval.view_approval');
    Route::get('pengajuan_tiv/pdf/{no_urut}', 'Pengajuan\PengajuanTivController@pdf')->name('pengajuan_tiv/pdf.pdf');
    Route::get('pengajuan_tiv/update/{no_urut}', 'Pengajuan\PengajuanTivController@approved')->name('pengajuan_tiv/update');
    Route::get('pengajuan_tiv/denied/{no_urut}', 'Pengajuan\PengajuanTivController@denied')->name('pengajuan_tiv/denied');
    Route::get('pengajuan_tiv/update_data/{no_urut}', 'Pengajuan\PengajuanTivController@update_data')->name('pengajuan_tiv/update_data');
    Route::post('pengajuan_tiv/edit', 'Pengajuan\PengajuanTivController@edit')->name('pengajuan_tiv/edit.edit');
    Route::get('pengajuan_tiv/pdf_spp/{no_urut}', 'Pengajuan\PengajuanTivController@pdf_spp')->name('pengajuan_tiv/pdf_spp.pdf_spp');

    Route::resource('pengajuan_tiv_masuk', 'Pengajuan\PengajuanTivMasukController')->except(['show']);
    Route::get('pengajuan_tiv_masuk/cari', 'Pengajuan\PengajuanTivMasukController@cari')->name('pengajuan_tiv_masuk/cari.cari');
    Route::get('pengajuan_tiv_masuk/view/{no_urut}', 'Pengajuan\PengajuanTivMasukController@view')->name('pengajuan_tiv_masuk/view.view');
    Route::post('pengajuan_tiv_masuk/view/approved', 'Pengajuan\PengajuanTivMasukController@approved')->name('pengajuan_tiv_masuk/view/approved.approved');
    Route::post('pengajuan_tiv_masuk/store', 'Pengajuan\PengajuanTivMasukController@store')->name('pengajuan_tiv_masuk/store');
    Route::get('pengajuan_tiv_masuk/pending/{no_urut}', 'Pengajuan\PengajuanTivMasukController@pending')->name('pengajuan_tiv_masuk/pending');
    Route::get('pengajuan_tiv_masuk/action_rekening', 'Pengajuan\PengajuanTivMasukController@actionRekening')->name('pengajuan_tiv_masuk/action_rekening.actionRekening');

    Route::resource('pengajuan_spp', 'Pengajuan\PengajuanSppController')->except(['show']);
    Route::get('pengajuan_spp/cari', 'Pengajuan\PengajuanSppController@cari')->name('pengajuan_spp/cari.cari');
    Route::get('pengajuan_spp/create/cari_data', 'Pengajuan\PengajuanSppController@cari_data')->name('pengajuan_spp/create/cari_data.cari_data');
    Route::get('pengajuan_spp/action_Biaya', 'Pengajuan\PengajuanSppController@actionBiaya')->name('pengajuan_spp/action_Biaya.actionBiaya');
    Route::get('pengajuan_spp/{no_urut}', 'Pengajuan\PengajuanSppController@view')->name('pengajuan_spp.view');
    Route::get('pengajuan_spp/view_approval/{no_urut}', 'Pengajuan\PengajuanSppController@view_approval')->name('pengajuan_spp/view_approval.view_approval');
    Route::get('pengajuan_spp/pdf/{no_urut}', 'Pengajuan\PengajuanSppController@pdf')->name('pengajuan_spp/pdf.pdf');

    Route::resource('pengajuan_lacak', 'Pengajuan\PengajuanLacakController')->except(['show']);
    Route::get('pengajuan_lacak/cari', 'Pengajuan\PengajuanLacakController@cari')->name('pengajuan_lacak/cari.cari');

    Route::resource('pengajuan_lacak_biaya', 'Pengajuan\PengajuanLacakBiayaController')->except(['show']);
    Route::get('pengajuan_lacak/cari_biaya', 'Pengajuan\PengajuanLacakBiayaController@cari_biaya')->name('pengajuan_lacak/cari_biaya.cari_biaya');

    /**######### General Affair (GA) ###################*/
    /** ######## Serah TErima Pengajuan User ######### **/
    Route::resource('serah_terima_user', 'PengajuanSerahTerimaUser\SerahTerimaController')->except(['show']);
    Route::get('serah_terima_user/cari', 'PengajuanSerahTerimaUser\SerahTerimaController@cari')->name('serah_terima_user/cari.cari');
    Route::get('serah_terima_user/view/{no_urut}', 'PengajuanSerahTerimaUser\SerahTerimaController@view')->name('serah_terima_user/view.view');
    Route::get('serah_terima_user/pdf/{no_urut}', 'PengajuanSerahTerimaUser\SerahTerimaController@pdf')->name('serah_terima_user/pdf.pdf');
    Route::post('serah_terima_user/approved', 'PengajuanSerahTerimaUser\SerahTerimaController@approved')->name('serah_terima_user/approved.approved');
    Route::get('serah_terima_user/approved/pdf', 'PengajuanSerahTerimaUser\SerahTerimaController@pdf_serah_terima')->name('serah_terima_user/approved/pdf');

    Route::resource('ga_rekap_atk', 'Ga\GaRekapAtkController')->except(['show']);
    Route::get('ga_rekap_atk/cari', 'Ga\GaRekapAtkController@cari')->name('ga_rekap_atk/cari.cari');
    Route::post('ga_rekap_atk/rekap_excel', 'Ga\GaRekapAtkController@rekap_excel')->name('ga_rekap_atk/rekap_excel.rekap_excel');

    Route::resource('ga_rekap_atk_non', 'Ga\GaRekapAtkNonController')->except(['show']);
    Route::get('ga_rekap_atk_non/cari', 'Ga\GaRekapAtkNonController@cari')->name('ga_rekap_atk_non/cari.cari');


    /** ######## End Serah TErima Pengajuan User ######### **/
    /** ######## BOD ######### **/
    Route::resource('bod_rekening', 'MasterBod\RekeningController')->except(['create', 'show']);

    Route::resource('bod_bank', 'MasterBod\BodBankCompanyController')->except(['create', 'show']);
    Route::get('bod_bank/get-banks/{kode_perusahaan}', 'MasterBod\BodBankCompanyController@getBanks')->name('bod_bank/get-banks.getBanks');
    Route::get('bod_bank/get-rekenings/{kode_perusahaan}/{kode_bank}', 'MasterBod\BodBankCompanyController@getRekenings')->name('bod_bank/get-rekenings.getRekenings');
    Route::get('bod_bank/get-pemegang/{kode_perusahaan}/{kode_bank}', 'MasterBod\BodBankCompanyController@getPemegang')->name('bod_bank/get-pemegang.getPemegang');

    Route::resource('bod_cheque', 'MasterBod\ChequeController')->except(['create', 'show']);
    Route::get('bod_cheque/getDataCheque', 'MasterBod\ChequeController@getDataCheque')->name('bod_cheque/getDataCheque.getDataCheque');

    Route::resource('bod_transfer', 'MasterBod\TransferController')->except(['create', 'show']);
    Route::get('bod_transfer/getDataTransfer', 'MasterBod\TransferController@getDataTransfer')->name('bod_transfer/getDataTransfer.getDataTransfer');

    Route::resource('bod_cheque_transfer', 'MasterBod\TransferController')->except(['create', 'show']);
    Route::get('bod_cheque_transfer/getDataChequeTransfer', 'MasterBod\TransferController@getDataChequeTransfer')->name('bod_cheque_transfer/getDataChequeTransfer.getDataChequeTransfer');

    Route::resource('bod_bank_vendor', 'MasterBod\BankVendorController')->except(['create', 'show']);
    Route::get('bod_bank_vendor/getDataBankVendor', 'MasterBod\BankVendorController@getDataBankVendor')->name('bod_bank_vendor/getDataBankVendor.getDataBankVendor');

    Route::resource('bod_spp_cheque', 'MasterBod\BodSppChequeController')->except(['create', 'show']);
    Route::get('bod_spp_cheque/getDataSppCheque', 'MasterBod\BodSppChequeController@getDataSppCheque')->name('bod_spp_cheque/getDataSppCheque.getDataSppCheque');

    Route::resource('bod_spp_transfer', 'MasterBod\BodSppTransferController')->except(['create', 'show']);
    Route::get('bod_spp_transfer/getDataSppTransfer', 'MasterBod\BodSppTransferController@getDataSppTransfer')->name('bod_spp_cheque/getDataSppTransfer.getDataSppTransfer');

    Route::resource('bod_spp_transfer_cek', 'MasterBod\BodSppTransferCekController')->except(['create', 'show']);
    Route::get('bod_spp_transfer_cek/getDataSppTransferCek', 'MasterBod\BodSppTransferCekController@getDataSppTransferCek')->name('bod_spp_transfer_cek/getDataSppTransferCek.getDataSppTransferCek');

    Route::resource('bod_settlement_spp_cek', 'MasterBod\BodSettlementSppCekController')->except(['create', 'show']);
    Route::get('bod_settlement_spp_cek/getSettlementSppCheque', 'MasterBod\BodSettlementSppCekController@getSettlementSppCheque')->name('bod_settlement_spp_cek/getSettlementSppCheque.getSettlementSppCheque');

    Route::resource('bod_settlement_permintaan_cek', 'MasterBod\BodPermintaanCekController')->except(['create', 'show']);
    Route::get('bod_settlement_permintaan_cek/getDataCheque', 'MasterBod\BodPermintaanCekController@getDataCheque')->name('bod_settlement_permintaan_cek/getDataCheque.getDataCheque');

    Route::resource('bod_monitoring_cheque', 'MasterBod\MonitoringChequeController')->except(['show']);

    Route::resource('bod', 'Bod\DaftarPengajuanBarangController')->except(['create', 'show']);
    Route::get('bod/cari', 'Bod\DaftarPengajuanBarangController@cari')->name('bod/cari.cari');

    Route::resource('bod_biaya', 'Bod\DaftarPengajuanBiayaController')->except(['create', 'show']);
    Route::get('bod_biaya/cari', 'Bod\DaftarPengajuanBiayaController@cari')->name('bod_biaya/cari.cari');

    Route::resource('bod_sppd', 'Bod\DaftarPengajuanSppdController')->except(['create', 'show']);
    Route::get('bod_sppd/cari', 'Bod\DaftarPengajuanSppdController@cari')->name('bod_sppd/cari.cari');

    Route::resource('bod_biaya_tunai_tp', 'Bod\DaftarPengajuanBiayaTunaiTanpaPersetujuanController')->except(['create', 'show']);
    Route::get('bod_biaya_tunai_tp/cari', 'Bod\DaftarPengajuanBiayaTunaiTanpaPersetujuanController@cari')->name('bod_biaya_tunai_tp/cari.cari');

    Route::resource('bod_biaya_tunai_p', 'Bod\DaftarPengajuanBiayaTunaiPersetujuanController')->except(['create', 'show']);
    Route::get('bod_biaya_tunai_p/cari', 'Bod\DaftarPengajuanBiayaTunaiPersetujuanController@cari')->name('bod_biaya_tunai_p/cari.cari');

    Route::resource('bod_biaya_tunai_pc', 'Bod\DaftarPengajuanBiayaTunaiPettyCashController')->except(['create', 'show']);
    Route::get('bod_biaya_tunai_pc/cari', 'Bod\DaftarPengajuanBiayaTunaiPettyCashController@cari')->name('bod_biaya_tunai_pc/cari.cari');

    Route::resource('bod_biaya_claim', 'Bod\DaftarPengajuanBiayaClaimController')->except(['create', 'show']);
    Route::get('bod_biaya_claim/cari', 'Bod\DaftarPengajuanBiayaClaimController@cari')->name('bod_biaya_claim/cari.cari');

    Route::resource('bod_claim_daftar_do', 'Bod\DaftarPengajuanBiayaClaimDoController')->except(['create', 'show']);

    Route::resource('bod_claim_daftar_perhitungan', 'Bod\DaftarPengajuanBiayaClaimRekapPerhitunganController')->except(['create', 'show']);

    Route::resource('bod_claim_daftar_hitunga_program', 'Bod\DaftarPengajuanBiayaClaimPerhitunganController')->except(['create', 'show']);

    Route::resource('bod_claim_daftar_persiapan_bayar', 'Bod\DaftarPengajuanBiayaClaimPersiapanBayar')->except(['create', 'show']);

    Route::resource('bod_claim_daftar_status_hitung', 'Bod\DaftarPengajuanBiayaClaimStatusHitung')->except(['create', 'show']);

    Route::resource('bod_status_pembayaran', 'Bod\DaftarPengajuanBiayaClaimPembayaranController')->except(['create', 'show']);

    Route::resource('bod_claim_daftar_upload', 'Bod\DaftarPengajuanBiayaClaimUpload')->except(['create', 'show']);

    Route::resource('bod_claim_daftar_otorisasi', 'Bod\DaftarPengajuanBiayaClaimOtorisasi')->except(['create', 'show']);

    Route::resource('bod_otorisasi', 'Bod\OtorisasiTransferController')->except(['show']);
    Route::get('bod_otorisasi/cari', 'Bod\OtorisasiTransferController@cari')->name('bod_otorisasi/cari.cari');
    Route::get('bod_otorisasi/view/{no_urut}', 'Bod\OtorisasiTransferController@view')->name('bod_otorisasi/view.view');
    Route::post('bod_otorisasi/otorisasi', 'Bod\OtorisasiTransferController@otorisasi')->name('bod_otorisasi/otorisasi');
    Route::post('bod_otorisasi/denied', 'Bod\OtorisasiTransferController@denied')->name('bod_otorisasi/denied.denied');

    Route::resource('bod_otorisasi_claim', 'Bod\OtorisasiTransferClaimController')->except(['show']);
    Route::get('/bod_otorisasi_claim/getData', 'Bod\OtorisasiTransferClaimController@getData')->name('bod_otorisasi_claim.getData');
    Route::get('/bod_otorisasi_claim/view', 'Bod\OtorisasiTransferClaimController@showView')->name('bod_otorisasi_claim/view');
    Route::get('/bod_otorisasi_claim_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimController@showDetail')->name('bod_otorisasi_claim_detail');
    Route::post('/bod_otorisasi_claim_detail/otorisasi', 'Bod\OtorisasiTransferClaimController@otorisasi')->name('bod_otorisasi_claim_detail/otorisasi.otorisasi');
    Route::post('/bod_otorisasi_claim_detail/batal', 'Bod\OtorisasiTransferClaimController@batal')->name('bod_otorisasi_claim_detail/batal.batal');

    Route::resource('otorisasi_claim_lp', 'Bod\OtorisasiTransferClaimLpPayController')->except(['show']);
    Route::get('/otorisasi_claim_lp/getData', 'Bod\OtorisasiTransferClaimLpPayController@getData')->name('otorisasi_claim_lp.getData');
    Route::get('/otorisasi_claim_lp/view', 'Bod\OtorisasiTransferClaimLpPayController@showView')->name('otorisasi_claim_lp/view');
    Route::get('/otorisasi_claim_lp_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimLpPayController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_lp_detail/otorisasi', 'Bod\OtorisasiTransferClaimLpPayController@otorisasi')->name('otorisasi_claim_lp_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_lp_detail/batal', 'Bod\OtorisasiTransferClaimLpPayController@batal')->name('otorisasi_claim_lp_detail/batal.batal');

    Route::resource('otorisasi_claim_ta_b', 'Bod\OtorisasiTransferClaimTaBiaController')->except(['show']);
    Route::get('/otorisasi_claim_ta_b/getData', 'Bod\OtorisasiTransferClaimTaBiaController@getData')->name('otorisasi_claim_ta_b.getData');
    Route::get('/otorisasi_claim_ta_b/view', 'Bod\OtorisasiTransferClaimTaBiaController@showView')->name('otorisasi_claim_ta_b/view');
    Route::get('/otorisasi_claim_ta_b_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTaBiaController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_ta_b_detail/otorisasi', 'Bod\OtorisasiTransferClaimTaBiaController@otorisasi')->name('otorisasi_claim_ta_b_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_ta_b_detail/batal', 'Bod\OtorisasiTransferClaimTaBiaController@batal')->name('otorisasi_claim_ta_b_detail/batal.batal');

    Route::resource('otorisasi_claim_ta_b_odbc', 'Bod\OtorisasiTransferClaimTaBiaOcbcController')->except(['show']);
    Route::get('/otorisasi_claim_ta_b_odbc/getData', 'Bod\OtorisasiTransferClaimTaBiaOcbcController@getData')->name('otorisasi_claim_ta_b_odbc.getData');
    Route::get('/otorisasi_claim_ta_b_odbc/view', 'Bod\OtorisasiTransferClaimTaBiaOcbcController@showView')->name('otorisasi_claim_ta_b_odbc/view');
    Route::get('/otorisasi_claim_ta_b_odbc_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTaBiaOcbcController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_ta_b_odbc_detail/otorisasi', 'Bod\OtorisasiTransferClaimTaBiaOcbcController@otorisasi')->name('otorisasi_claim_ta_b_odbc_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_ta_b_odbc_detail/batal', 'Bod\OtorisasiTransferClaimTaBiaOcbcController@batal')->name('otorisasi_claim_ta_b_odbc_detail/batal.batal');

    Route::resource('otorisasi_claim_ta_p', 'Bod\OtorisasiTransferClaimTaPayController')->except(['show']);
    Route::get('/otorisasi_claim_ta_p/getData', 'Bod\OtorisasiTransferClaimTaPayController@getData')->name('otorisasi_claim_ta_p.getData');
    Route::get('/otorisasi_claim_ta_p/view', 'Bod\OtorisasiTransferClaimTaPayController@showView')->name('otorisasi_claim_ta_p/view');
    Route::get('/otorisasi_claim_ta_p_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTaPayController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_ta_p_detail/otorisasi', 'Bod\OtorisasiTransferClaimTaPayController@otorisasi')->name('otorisasi_claim_ta_p_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_ta_p_detail/batal', 'Bod\OtorisasiTransferClaimTaPayController@batal')->name('otorisasi_claim_ta_p_detail/batal.batal');

    Route::resource('otorisasi_claim_ta_p_odbc', 'Bod\OtorisasiTransferClaimTaPeOcbcController')->except(['show']);
    Route::get('/otorisasi_claim_ta_p_odbc/getData', 'Bod\OtorisasiTransferClaimTaPeOcbcController@getData')->name('otorisasi_claim_ta_p_odbc.getData');
    Route::get('/otorisasi_claim_ta_p_odbc/view', 'Bod\OtorisasiTransferClaimTaPeOcbcController@showView')->name('otorisasi_claim_ta_p_odbc/view');
    Route::get('/otorisasi_claim_ta_p_odbc_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTaPeOcbcController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_ta_p_odbc_detail/otorisasi', 'Bod\OtorisasiTransferClaimTaPeOcbcController@otorisasi')->name('otorisasi_claim_ta_p_odbc_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_ta_p_odbc_detail/batal', 'Bod\OtorisasiTransferClaimTaPeOcbcController@batal')->name('otorisasi_claim_ta_p_odbc_detail/batal.batal');

    Route::resource('otorisasi_claim_tgsm', 'Bod\OtorisasiTransferClaimTgsmPayController')->except(['show']);
    Route::get('/otorisasi_claim_tgsm/getData', 'Bod\OtorisasiTransferClaimTgsmPayController@getData')->name('otorisasi_claim_tgsm.getData');
    Route::get('/otorisasi_claim_tgsm/view', 'Bod\OtorisasiTransferClaimTgsmPayController@showView')->name('otorisasi_claim_tgsm/view');
    Route::get('/otorisasi_claim_ta_tgsm_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTgsmPayController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_ta_tgsm_detail/otorisasi', 'Bod\OtorisasiTransferClaimTgsmPayController@otorisasi')->name('otorisasi_claim_ta_tgsm_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_ta_tgsm_detail/batal', 'Bod\OtorisasiTransferClaimTgsmPayController@batal')->name('otorisasi_claim_ta_tgsm_detail/batal.batal');

    Route::resource('otorisasi_claim_tta_p', 'Bod\OtorisasiTransferClaimTtaPayController')->except(['show']);
    Route::get('/otorisasi_claim_tta_p/getData', 'Bod\OtorisasiTransferClaimTtaPayController@getData')->name('otorisasi_claim_tta_p.getData');
    Route::get('/otorisasi_claim_tta_p/view', 'Bod\OtorisasiTransferClaimTtaPayController@showView')->name('otorisasi_claim_tta_p/view');
    Route::get('/otorisasi_claim_tta_p_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTtaPayController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tta_p_detail/otorisasi', 'Bod\OtorisasiTransferClaimTtaPayController@otorisasi')->name('otorisasi_claim_tta_p_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tta_p_detail/batal', 'Bod\OtorisasiTransferClaimTtaPayController@batal')->name('otorisasi_claim_tta_p_detail/batal.batal');

    Route::resource('otorisasi_claim_tua_bbca', 'Bod\OtorisasiTransferClaimTuaBiaBcaController')->except(['show']);
    Route::get('/otorisasi_claim_tua_bbca/getData', 'Bod\OtorisasiTransferClaimTuaBiaBcaController@getData')->name('otorisasi_claim_tua_bbca.getData');
    Route::get('/otorisasi_claim_tua_bbca/view', 'Bod\OtorisasiTransferClaimTuaBiaBcaController@showView')->name('otorisasi_claim_tua_bbca/view');
    Route::get('/otorisasi_claim_tua_bbca_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuaBiaBcaController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tua_bbca_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuaBiaBcaController@otorisasi')->name('otorisasi_claim_tua_bbca_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tua_bbca_detail/batal', 'Bod\OtorisasiTransferClaimTuaBiaBcaController@batal')->name('otorisasi_claim_tua_bbca_detail/batal.batal');

    Route::resource('otorisasi_claim_tua_bocbc', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController')->except(['show']);
    Route::get('/otorisasi_claim_tua_bocbc/getData', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController@getData')->name('otorisasi_claim_tua_bocbc.getData');
    Route::get('/otorisasi_claim_tua_bocbc/view', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController@showView')->name('otorisasi_claim_tua_bocbc/view');
    Route::get('/otorisasi_claim_tua_bocbc_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tua_bocbc_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController@otorisasi')->name('otorisasi_claim_tua_bocbc_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tua_bocbc_detail/batal', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController@batal')->name('otorisasi_claim_tua_bocbc_detail/batal.batal');
    Route::get('/otorisasi_claim_tua_bocbc/view_data', 'Bod\OtorisasiTransferClaimTuaBiaOcbcController@view_data_all')->name('otorisasi_claim_tua_bocbc/view_data.view_data_all');

    Route::resource('otorisasi_claim_tua_p', 'Bod\OtorisasiTransferClaimTuaPayController')->except(['show']);
    Route::get('/otorisasi_claim_tua_p/getData', 'Bod\OtorisasiTransferClaimTuaPayController@getData')->name('otorisasi_claim_tua_p.getData');
    Route::get('/otorisasi_claim_tua_p/view', 'Bod\OtorisasiTransferClaimTuaPayController@showView')->name('otorisasi_claim_tua_p/view');
    Route::get('/otorisasi_claim_tua_p_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuaPayController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tua_p_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuaPayController@otorisasi')->name('otorisasi_claim_tua_p_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tua_p_detail/batal', 'Bod\OtorisasiTransferClaimTuaPayController@batal')->name('otorisasi_claim_tua_p_detail/batal.batal');

    Route::resource('otorisasi_claim_tu_b', 'Bod\OtorisasiTransferClaimTuBiaController')->except(['show']);
    Route::get('/otorisasi_claim_tu_b/getData', 'Bod\OtorisasiTransferClaimTuBiaController@getData')->name('otorisasi_claim_tu_b.getData');
    Route::get('/otorisasi_claim_tu_b/view', 'Bod\OtorisasiTransferClaimTuBiaController@showView')->name('otorisasi_claim_tu_b/view');
    Route::get('/otorisasi_claim_tu_b_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuBiaController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tu_b_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuBiaController@otorisasi')->name('otorisasi_claim_tu_b_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tu_b_detail/batal', 'Bod\OtorisasiTransferClaimTuBiaController@batal')->name('otorisasi_claim_tu_b_detail/batal.batal');

    Route::resource('otorisasi_claim_tu_b_odbc', 'Bod\OtorisasiTransferClaimTuBiaOcbcController')->except(['show']);
    Route::get('/otorisasi_claim_tu_b_odbc/getData', 'Bod\OtorisasiTransferClaimTuBiaOcbcController@getData')->name('otorisasi_claim_tu_b_odbc.getData');
    Route::get('/otorisasi_claim_tu_b_odbc/view', 'Bod\OtorisasiTransferClaimTuBiaOcbcController@showView')->name('otorisasi_claim_tu_b_odbc/view');
    Route::get('/otorisasi_claim_tu_b_odbc_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuBiaOcbcController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tu_b_odbc_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuBiaOcbcController@otorisasi')->name('otorisasi_claim_tu_b_odbc_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tu_b_odbc_detail/batal', 'Bod\OtorisasiTransferClaimTuBiaOcbcController@batal')->name('otorisasi_claim_tu_b_odbc_detail/batal.batal');

    Route::resource('otorisasi_claim_tu_p', 'Bod\OtorisasiTransferClaimTuPayController')->except(['show']);
    Route::get('/otorisasi_claim_tu_p/getData', 'Bod\OtorisasiTransferClaimTuPayController@getData')->name('otorisasi_claim_tu_p.getData');
    Route::get('/otorisasi_claim_tu_p/view', 'Bod\OtorisasiTransferClaimTuPayController@showView')->name('otorisasi_claim_tu_p/view');
    Route::get('/otorisasi_claim_tu_p_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuPayController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tu_p_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuPayController@otorisasi')->name('otorisasi_claim_tu_p_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tu_p_detail/batal', 'Bod\OtorisasiTransferClaimTuPayController@batal')->name('otorisasi_claim_tu_p_detail/batal.batal');

    Route::resource('otorisasi_claim_tu_p_odbc', 'Bod\OtorisasiTransferClaimTuPeOcbcController')->except(['show']);
    Route::get('/otorisasi_claim_tu_p_odbc/getData', 'Bod\OtorisasiTransferClaimTuPeOcbcController@getData')->name('otorisasi_claim_tu_p_odbc.getData');
    Route::get('/otorisasi_claim_tu_p_odbc/view', 'Bod\OtorisasiTransferClaimTuPeOcbcController@showView')->name('otorisasi_claim_tu_p_odbc/view');
    Route::get('/otorisasi_claim_tu_p_odbc_detail/{no_urut_pengajuan_biaya}', 'Bod\OtorisasiTransferClaimTuPeOcbcController@showDetail')->name('otorisasi_claim_detail');
    Route::post('/otorisasi_claim_tu_p_odbc_detail/otorisasi', 'Bod\OtorisasiTransferClaimTuPeOcbcController@otorisasi')->name('otorisasi_claim_tu_p_odbc_detail/otorisasi.otorisasi');
    Route::post('/otorisasi_claim_tu_p_odbc_detail/batal', 'Bod\OtorisasiTransferClaimTuPeOcbcController@batal')->name('otorisasi_claim_tu_p_odbc_detail/batal.batal');


    Route::prefix('status_cheque')->name('status_cheque.')->group(function () {
        Route::get('/', 'Bod\StatusChequeController@index')->name('index');
        Route::get('/data', 'Bod\StatusChequeController@getData')->name('getData');
        Route::post('/', 'Bod\StatusChequeController@store')->name('store');
        Route::put('/{id}', 'Bod\StatusChequeController@update')->name('update');
        Route::delete('/{id}', 'Bod\StatusChequeController@destroy')->name('destroy');
    });


    /** Filter Pengajuan **/
    Route::resource('filter_pengajuan', 'FilterPengajuan\FilterPengajuanController')->except(['create', 'show']);
    Route::get('filter_pengajuan/getDataPengajuan', 'FilterPengajuan\FilterPengajuanController@getDataPengajuan')->name('getDataPengajuan');
    Route::get('filter_pengajuan/getDataPengajuanTa', 'FilterPengajuan\FilterPengajuanController@getDataPengajuanTa')->name('getDataPengajuanTa');
    Route::get('filter_pengajuan/getDataPengajuanTu', 'FilterPengajuan\FilterPengajuanController@getDataPengajuanTu')->name('getDataPengajuanTu');
    /** ###################### **/

    /** ######## Approval ######### */
    Route::resource('approval', 'Approval\ApprovalController')->except(['create', 'show']);
    Route::get('approval/cari', 'Approval\ApprovalController@cari')->name('approval/cari.cari');
    Route::get('approval/{kode_pengajuan}', 'Approval\ApprovalController@view')->name('approval.view');
    Route::get('approval-update/{kode_pengajuan}', 'Approval\ApprovalController@approved')->name('approval-update');
    //Route::post('approval_update', 'Approval\ApprovalController@approved')->name('approval_update.approved');
    Route::get('approval-denied/{kode_pengajuan}', 'Approval\ApprovalController@denied')->name('approval-denied');
    Route::get('approval-pending/{kode_pengajuan}', 'Approval\ApprovalController@pending')->name('approval-pending');
    //tambahan baru //
    Route::post('approval/approved', 'Approval\ApprovalController@approved')->name('approval/approved.approved');
    Route::post('approval/pending', 'Approval\ApprovalController@pending')->name('approval/pending.pending');
    Route::post('approval/denied', 'Approval\ApprovalController@denied')->name('approval/denied.denied');

    Route::resource('approval_bod', 'Approval\ApprovalBodController')->except(['create', 'show']);
    Route::get('approval_bod/cari', 'Approval\ApprovalBodController@cari')->name('approval_bod/cari.cari');
    Route::get('approval_bod/{kode_pengajuan}', 'Approval\ApprovalBodController@view')->name('approval_bod.view');
    Route::get('approval-bod-update/{kode_pengajuan}', 'Approval\ApprovalBodController@approved')->name('approval-bod-update');
    Route::get('approval-bod-denied/{kode_pengajuan}', 'Approval\ApprovalBodController@denied')->name('approval-bod-denied');
    Route::get('approval-bod-pending/{kode_pengajuan}', 'Approval\ApprovalBodController@pending')->name('approval-bod-pending');

    Route::resource('approval_bod_cost', 'Approval\ApprovalBodCostController')->except(['create', 'show']);
    Route::get('approval_bod_cost/cari', 'Approval\ApprovalBodCostController@cari')->name('approval_bod_cost/cari.cari');
    Route::get('approval_bod_cost/{kode_pengajuan}', 'Approval\ApprovalBodCostController@view')->name('approval_bod_cost.view');
    Route::get('approval-bod-cost-update/{kode_pengajuan}', 'Approval\ApprovalBodCostController@approved')->name('approval-bod-cost-update');
    Route::get('approval-bod-cost-denied/{kode_pengajuan}', 'Approval\ApprovalBodCostController@denied')->name('approval-bod-cost-denied');
    Route::get('approval-bod-cost -pending/{kode_pengajuan}', 'Approval\ApprovalBodCostController@pending')->name('approval-bod-cost-pending');

    Route::resource('approval_bod_sppd', 'Approval\ApprovalBodSppdController')->except(['create', 'show']);
    Route::get('approval_bod_sppd/cari', 'Approval\ApprovalBodSppdController@cari')->name('approval_bod_sppd/cari.cari');
    Route::get('approval_bod_sppd/view/{kode_pengajuan_sppd}', 'Approval\ApprovalBodSppdController@view')->name('approval_bod_sppd/view.view');
    Route::get('approval_bod_sppd_update/{kode_pengajuan_sppd}', 'Approval\ApprovalBodSppdController@approved')->name('approval_bod_sppd_update');
    Route::get('approval_bod_sppd_denied/{kode_pengajuan_sppd}', 'Approval\ApprovalBodSppdController@denied')->name('approval_bod_sppd_denied');
    Route::get('approval_bod_sppd_pending/{kode_pengajuan_sppd}', 'Approval\ApprovalBodSppdController@pending')->name('approval_bod_sppd_pending');

    Route::resource('approval_bod_biaya_tp', 'Approval\ApprovalBodBiayaTunaiTanpaPersetujuanController')->except(['create', 'show']);
    Route::get('approval_bod_biaya_tp/cari', 'Approval\ApprovalBodBiayaTunaiTanpaPersetujuanController@cari')->name('approval_bod_biaya_tp/cari.cari');
    Route::get('approval_bod_biaya_tp/{no_urut}', 'Approval\ApprovalBodBiayaTunaiTanpaPersetujuanController@view')->name('approval_bod_biaya_tp.view');

    Route::resource('approval_bod_biaya_p', 'Approval\ApprovalBodBiayaTunaiPersetujuanController')->except(['create', 'show']);
    Route::get('approval_bod_biaya_p/cari', 'Approval\ApprovalBodBiayaTunaiPersetujuanController@cari')->name('approval_bod_biaya_p/cari.cari');
    Route::get('approval_bod_biaya_p/{no_urut}', 'Approval\ApprovalBodBiayaTunaiPersetujuanController@view')->name('approval_bod_biaya_p.view');

    Route::resource('approval_bod_biaya_pc', 'Approval\ApprovalBodBiayaPettyCashController')->except(['create', 'show']);
    Route::get('approval_bod_biaya_pc/cari', 'Approval\ApprovalBodBiayaPettyCashController@cari')->name('approval_bod_biaya_pc/cari.cari');
    Route::get('approval_bod_biaya_pc/{no_urut}', 'Approval\ApprovalBodBiayaPettyCashController@view')->name('approval_bod_biaya_pc.view');

    Route::resource('approval_bod_biaya_claim', 'Approval\ApprovalBodBiayaClaimController')->except(['create', 'show']);
    Route::get('approval_bod_biaya_claim/cari', 'Approval\ApprovalBodBiayaClaimController@cari')->name('approval_bod_biaya_claim/cari.cari');
    Route::get('approval_bod_biaya_claim/{no_urut}', 'Approval\ApprovalBodBiayaClaimController@view')->name('approval_bod_biaya_claim.view');

    Route::resource('approval_bod_biaya_prepaid', 'Approval\ApprovalBodBiayaPrepaidController')->except(['create', 'show']);
    Route::get('approval_bod_biaya_prepaid/cari', 'Approval\ApprovalBodBiayaPrepaidController@cari')->name('approval_bod_biaya_prepaid/cari.cari');
    Route::get('approval_bod_biaya_prepaid/{no_urut}', 'Approval\ApprovalBodBiayaPrepaidController@view')->name('approval_bod_biaya_prepaid.view');

    Route::resource('approval_cost', 'Approval\ApprovalCostController')->except(['create', 'show']);
    Route::get('approval_cost/cari', 'Approval\ApprovalCostController@cari')->name('approval_cost/cari.cari');
    Route::get('approval_cost/{no_urut}', 'Approval\ApprovalCostController@view')->name('approval_cost.view');
    Route::get('approval_cost_update/{no_urut}', 'Approval\ApprovalCostController@approved')->name('approval_cost_update');
    Route::get('approval_cost_denied/{no_urut}', 'Approval\ApprovalCostController@denied')->name('approval_cost_denied');
    Route::get('approval_cost_pending/{no_urut}', 'Approval\ApprovalCostController@pending')->name('approval_cost_pending');
    //tambahan baru //
    Route::post('approval_cost/approved', 'Approval\ApprovalCostController@approved')->name('approval_cost/approved.approved');
    Route::post('approval_cost/denied', 'Approval\ApprovalCostController@denied')->name('approval_cost/denied.denied');
    Route::post('approval_cost/pending', 'Approval\ApprovalCostController@pending')->name('approval_cost/pending.pending');

    Route::resource('approval_cost_bbm_sales', 'Approval\ApprovalBiayaBbmSalesController')->except(['create', 'show']);

    Route::resource('approval_vendor', 'Approval\ApprovalVendorController')->except(['create', 'show']);
    Route::get('approval_vendor/cari', 'Approval\ApprovalVendorController@cari')->name('approval_vendor/cari.cari');
    Route::get('approval_vendor/view/{kode_pengajuan_v}', 'Approval\ApprovalVendorController@view')->name('approval_vendor/view.view');
    Route::get('approval_vendor_denied/{kode_pengajuan_v}', 'Approval\ApprovalVendorController@denied')->name('approval_vendor_denied');
    Route::get('approval_vendor_pending/{kode_pengajuan_v}', 'Approval\ApprovalVendorController@pending')->name('approval_vendor_pending');

    Route::resource('approval_sppd', 'Approval\ApprovalSppdController')->except(['create', 'show']);
    Route::get('approval_sppd/cari', 'Approval\ApprovalSppdController@cari')->name('approval_sppd/cari.cari');
    Route::get('approval_sppd/view/{kode_pengajuan_sppd}', 'Approval\ApprovalSppdController@view')->name('approval_sppd/view.view');
    Route::get('approval_sppd_update/{kode_pengajuan_sppd}', 'Approval\ApprovalSppdController@approved')->name('approval_sppd_update');
    Route::get('approval_sppd_denied/{kode_pengajuan_sppd}', 'Approval\ApprovalSppdController@denied')->name('approval_sppd_denied');
    Route::get('approval_sppd_pending/{kode_pengajuan_sppd}', 'Approval\ApprovalSppdController@pending')->name('approval_sppd_pending');

    Route::resource('approval_tiv', 'Approval\ApprovalTivController')->except(['create', 'show']);
    Route::get('approval_tiv/cari', 'Approval\ApprovalTivController@cari')->name('approval_tiv/cari.cari');
    Route::get('approval_tiv/view/{no_urut}', 'Approval\ApprovalTivController@view')->name('approval_tiv/view.view');
    //Route::get('approval_tiv/approved/{no_urut}', 'Approval\ApprovalTivController@approved')->name('approval_tiv/approved.approved');
    //Route::get('approval_tiv/denied/{no_urut}', 'Approval\ApprovalTivController@denied')->name('approval_tiv/denied.denied');
    //Route::get('approval_tiv/pending/{no_urut}', 'Approval\ApprovalTivController@pending')->name('approval_tiv/pending.pending');
    //tambahan baru //
    Route::post('approval_tiv/approved', 'Approval\ApprovalTivController@approved')->name('approval_tiv/approved.approved');
    Route::post('approval_tiv/denied', 'Approval\ApprovalTivController@denied')->name('approval_tiv/denied.denied');
    Route::post('approval_tiv/pending', 'Approval\ApprovalTivController@pending')->name('approval_tiv/pending.pending');

    Route::resource('approval_spp', 'Approval\ApprovalSppController')->except(['create', 'show']);
    Route::get('approval_spp/cari', 'Approval\ApprovalSppController@cari')->name('approval_spp/cari.cari');
    Route::get('approval_spp/search', 'Approval\ApprovalSppController@search')->name('approval_spp.search');
    Route::get('approval_spp/search_manual', 'Approval\ApprovalSppController@search_manual')->name('approval_spp.search_manual');

    Route::get('approval_spp/view/{no_urut}', 'Approval\ApprovalSppController@view_p_claim')->name('approval_spp/view_p_claim.view_p_claim');
    Route::get('approval_spp/{no_urut}', 'Approval\ApprovalSppController@view')->name('approval_spp.view');
    Route::get('approval_spp_manual/{no_urut}', 'Approval\ApprovalSppController@view_manual')->name('approval_spp_manual.view_manual');
    Route::get('approval_spp_update/{no_urut}', 'Approval\ApprovalSppController@approved')->name('approval_spp_update');
    Route::get('approval_spp_update_manual/{no_urut}', 'Approval\ApprovalSppController@approved_manual')->name('approval_spp_update_manual');
    Route::get('approval_spp_denied/{no_urut}', 'Approval\ApprovalSppController@denied')->name('approval_spp_denied');
    Route::get('approval_spp_denied_manual/{no_urut}', 'Approval\ApprovalSppController@denied_manual')->name('approval_spp_denied_manual');
    Route::get('approval_spp_pending/{no_urut}', 'Approval\ApprovalSppController@pending')->name('approval_spp_pending');
    Route::get('approval_spp_pending_manual/{no_urut}', 'Approval\ApprovalSppController@pending_manual')->name('approval_spp_pending_manual');

    Route::resource('approval_kontrabon', 'Approval\ApprovalKontrabonController')->except(['create', 'show']);
    Route::get('approval_kontrabon/cari', 'Approval\ApprovalKontrabonController@cari')->name('approval_kontrabon/cari.cari');
    Route::get('approval_kontrabon/view/{no_kontrabon}', 'Approval\ApprovalKontrabonController@view')->name('approval_kontrabon/view.view');
    Route::post('approval_kontrabon/view/approved', 'Approval\ApprovalKontrabonController@approved')->name('approval_kontrabon/view/approved.approved');

    /** ######## purchasing ######### */
    Route::resource('purchasing', 'Purchasing\PurchasingController')->except(['show']);
    Route::get('purchasing/cari', 'Purchasing\PurchasingController@cari')->name('purchasing/cari.cari');
    Route::get('/purchasing/action_vendor', 'Purchasing\PurchasingController@actionVendor')->name('purchasing/action_vendor.actionVendor');
    Route::get('/purchasing/action_product', 'Purchasing\PurchasingController@actionProduct')->name('purchasing/action_product.actionProduct');
    Route::get('purchasing/{no_urut_po}', 'Purchasing\PurchasingController@view')->name('purchasing.view');
    Route::get('purchasing/pdf/{no_urut_po}', 'Purchasing\PurchasingController@pdf')->name('purchasing.order_pdf');
    Route::get('purchasing/excel/{no_urut_po}', 'Purchasing\PurchasingController@excel')->name('purchasing.order_excel');
    Route::get('purchasing_accept/{no_urut_po}', 'Purchasing\PurchasingController@accept')->name('purchasing_accept.accept');
    Route::post('purchasing_accepted', 'Purchasing\PurchasingController@accepted')->name('purchasing_accepted.accepted');
    Route::get('purchasing_accepted/pdf_penerimaan/{no_faktur}', 'Purchasing\PurchasingController@pdf_penerimaan')->name('purchasing_accepted/pdf_penerimaan');

    Route::resource('accepted', 'Purchasing\AcceptedController')->except(['show']);
    Route::get('accepted/cari', 'Purchasing\AcceptedController@cari')->name('accepted/cari.cari');
    Route::get('accepted/action_coa', 'Purchasing\AcceptedController@actionCoa')->name('accepted/action_coa.actionCoa');
    Route::get('accepted/action_category', 'Purchasing\AcceptedController@actionCategory')->name('accepted/action_category.actionCategory');
    Route::get('accepted/view/{no_faktur}', 'Purchasing\AcceptedController@view_accepted')->name('accepted/view.view_accepted');
    Route::get('accepted/create/{no_faktur}', 'Purchasing\AcceptedController@create')->name('accepted/create.created');

    Route::get('accepted/create/view_invoice/{no_faktur}', 'Purchasing\AcceptedController@view')->name('accepted/create/view_invoice.view_detail');
    Route::post('accepted/create/store', 'Purchasing\AcceptedController@store')->name('accepted/create/store.store');

    Route::resource('request_purchasing', 'Purchasing\RequestController')->except(['show']);
    Route::get('request_purchasing/cari', 'Purchasing\RequestController@cari')->name('request_purchasing/cari.cari');
    Route::get('request_purchasing/request_purchasing_view/{kode_pengajuan}', 'Purchasing\RequestController@view')->name('request_purchasing/request_purchasing_view.view');
    Route::get('request_purchasing/action_vendor', 'Purchasing\RequestController@actionVendor')->name('request_purchasing/action_vendor.actionVendor');
    Route::get('create_order/{kode_pengajuan}', 'Purchasing\RequestController@create')->name('create_order.create');
    Route::post('request_purchasing_order', 'Purchasing\RequestController@store')->name('request_purchasing_order.store');

    Route::resource('request_cost', 'Purchasing\RequestCostController')->except(['show']);
    Route::get('request_cost/cari', 'Purchasing\RequestCostController@cari')->name('request_cost/cari.cari');
    Route::get('request_cost_view/{no_urut}', 'Purchasing\RequestCostController@view')->name('request_cost_view.view');
    Route::get('request_cost-pay/{no_urut}', 'Purchasing\RequestCostController@pay')->name('request_cost-pay');
    Route::get('request_cost-update/{no_urut}', 'Purchasing\RequestCostController@approved')->name('request_cost-update');
    Route::get('request_cost-denied/{no_urut}', 'Purchasing\RequestCostController@denied')->name('request_cost-denied');
    Route::get('request_cost-pending/{no_urut}', 'Purchasing\RequestCostController@pending')->name('request_cost-pending');

    Route::resource('request_sppd', 'Purchasing\RequestSppdController')->except(['show']);

    Route::resource('counter_bill', 'Purchasing\CounterBillController')->except(['show']);
    Route::get('/counter_bill/action_vendor', 'Purchasing\CounterBillController@actionVendor')->name('counter_bill/action_vendor.actionVendor');
    Route::get('/counter_bill/action_invoice', 'Purchasing\CounterBillController@actionInvoice')->name('counter_bill/action_invoice.actionInvoice');
    Route::get('/counter_bill/action_category', 'Purchasing\CounterBillController@actionCategory')->name('counter_bill/action_category.actionCategory');
    Route::get('counter_bill/create/view_invoice/{no_faktur}', 'Purchasing\CounterBillController@view_detail')->name('counter_bill/create/view_invoice.view_detail');
    Route::get('counter_bill/view_detail/{no_kontrabon}', 'Purchasing\CounterBillController@view')->name('counter_bill/view_detail.view');
    Route::resource('supplier_bill', 'Purchasing\SupplierBillController')->except(['show']);
    Route::get('supplier_bill/cari', 'Purchasing\SupplierBillController@cari')->name('supplier_bill/cari.cari');
    Route::get('supplier_bill/{no_kontrabon}', 'Purchasing\SupplierBillController@view')->name('supplier_bill.view');

    Route::resource('po_gabungan', 'Purchasing\GabunganController')->except(['show']);
    Route::get('po_gabungan/getDataCreatePo', 'Purchasing\GabunganController@getDataCreatePo')->name('po_gabungan/getDataCreatePo');
    Route::get('po_gabungan/cari', 'Purchasing\GabunganController@cari')->name('po_gabungan/cari.cari');
    Route::get('po_gabungan/action_vendor', 'Purchasing\GabunganController@actionVendor')->name('po_gabungan/action_vendor.actionVendor');
    Route::get('po_gabungan/create', 'Purchasing\GabunganController@create')->name('po_gabungan/create');
    Route::post('po_gabungan/store', 'Purchasing\GabunganController@store')->name('po_gabungan/store');

    Route::resource('po_gabungan_non_atk', 'Purchasing\GabunganNonAtkController')->except(['show']);
    Route::get('po_gabungan_non_atk/getDataCreatePo', 'Purchasing\GabunganNonAtkController@getDataCreatePo')->name('po_gabungan_non_atk/getDataCreatePo');
    Route::get('po_gabungan_non_atk/cari', 'Purchasing\GabunganNonAtkController@cari')->name('po_gabungan_non_atk/cari.cari');
    Route::get('po_gabungan_non_atk/action_vendor', 'Purchasing\GabunganNonAtkController@actionVendor')->name('po_gabungan_non_atk/action_vendor.actionVendor');
    Route::get('po_gabungan_non_atk/create', 'Purchasing\GabunganNonAtkController@create')->name('po_gabungan_non_atk/create');
    //Route::post('po_gabungan_non_atk/store', 'Purchasing\GabunganNonAtkController@store')->name('po_gabungan_non_atk/store');

    Route::resource('rekap_atk', 'Purchasing\RekapAtkController')->except(['show']);
    Route::get('rekap_atk/cari', 'Purchasing\RekapAtkController@cari')->name('rekap_atk/cari.cari');
    Route::get('rekap_atk/cari_all', 'Purchasing\RekapAtkController@cari_all')->name('rekap_atk/cari_all.cari_all');
    Route::post('rekap_atk/store', 'Purchasing\RekapAtkController@store')->name('rekap_atk/store');

    Route::resource('rekap_data_atk', 'Purchasing\RekapAtkDataController')->except(['show']);
    Route::get('rekap_data_atk/cari', 'Purchasing\RekapAtkDataController@cari')->name('rekap_data_atk/cari.cari');
    Route::get('rekap_data_atk/{no_urut}', 'Purchasing\RekapAtkDataController@view')->name('rekap_data_atk.view');
    Route::get('rekap_data_atk/pdf/{no_urut}', 'Purchasing\RekapAtkDataController@pdf')->name('rekap_data_atk/pdf.pdf');
    Route::get('rekap_data_atk_update/{no_urut}', 'Purchasing\RekapAtkDataController@ubah')->name('rekap_data_atk_update.ubah');
    //Route::get('rekap_data_atk/rekap', 'Purchasing\RekapAtkDataController@rekap')->name('rekap_data_atk/rekap.rekap');
    Route::post('rekap_data_atk/rekap', 'Purchasing\RekapAtkDataController@rekap')->name('rekap_data_atk/rekap.rekap');

    Route::resource('rekap_atk_app', 'Purchasing\RekapAtkAppController')->except(['show']);
    Route::get('rekap_atk_app/cari', 'Purchasing\RekapAtkAppController@cari')->name('rekap_atk_app/cari.cari');
    Route::get('rekap_atk_app/{no_urut}', 'Purchasing\RekapAtkAppController@view')->name('rekap_atk_app.view');
    Route::post('rekap_atk_app/view/approved', 'Purchasing\RekapAtkAppController@approved')->name('rekap_atk_app/view/approved.approved');
    Route::post('rekap_atk_app/view/pending', 'Purchasing\RekapAtkAppController@pending')->name('rekap_atk_app/view/pending.pending');
// Route::get('rekap_atk_app/cari_all','Purchasing\RekapAtkController@cari_all')->name('rekap_atk/cari_all.cari_all');
// Route::post('rekap_atk_app/store','Purchasing\RekapAtkController@store')->name('rekap_atk/store');

//Route::get('supplier_bill', 'Purchasing\SupplierBillController@index')->name('supplier_bill.index');
//Route::get('supplier_bill/panel', 'Purchasing\SupplierBillController@panel')->name('supplier_bill.panel');


    /** ######## Accounting ######### */
    Route::resource('jurnal_umum', 'Accounting\JurnalUmumController')->except(['show']);
    Route::get('jurnal_umum/cari', 'Accounting\JurnalUmumController@cari')->name('jurnal_umum/cari.cari');

    #TUA
    Route::resource('due_date', 'Accounting\DueDateController')->except(['show']);
    Route::get('due_date/cari', 'Accounting\DueDateController@duedatecari')->name('duedate.duedatecari');
    Route::post('due_date/simpan', 'Accounting\DueDateController@store')->name('due_date_simpan.store');

    #Alfred
    Route::resource('due_date_alfred', 'Accounting\DueDateAlfredController')->except(['show']);
    Route::get('due_date_alfred/cari', 'Accounting\DueDateAlfredController@duedatecari')->name('duedate_alfred.duedatecari');
    Route::post('due_date_alfred/simpan', 'Accounting\DueDateAlfredController@store')->name('due_date_alfred_simpan.store');

    #DTS
    Route::resource('due_date_dts', 'Accounting\DueDateDtsController')->except(['show']);
    Route::get('due_date_dts/cari', 'Accounting\DueDateDtsController@duedatecari')->name('duedate_dts.duedatecari');
    Route::post('due_date_dts/simpan', 'Accounting\DueDateDtsController@store')->name('due_date_dts_simpan.store');

    #SUKANDA
    Route::resource('due_date_sukanda', 'Accounting\DueDateSukandaController')->except(['show']);
    Route::get('due_date_sukanda/cari', 'Accounting\DueDateSukandaController@duedatecari')->name('duedate_sukanda.duedatecari');
    Route::post('due_date_sukanda/simpan', 'Accounting\DueDateSukandaController@store')->name('due_date_sukanda_simpan.store');

    /** ######## Korsis ######### */
    Route::resource('list_due_date', 'Korsis\ListDueDateController')->except(['show']);
    Route::get('list_due_date/cari', 'Korsis\ListDueDateController@listcari')->name('list_due_date.listcari');
    Route::post('list_due_date/view', 'korsis\ListDueDateController@view')->name('list_due_date.view');
    Route::get('list_due_date/export', 'Korsis\ListDueDateController@export')->name('list_due_date/export.export');

    /** ######## Korsis Alfred ######### */
    Route::resource('list_due_date_alfred', 'Korsis\ListDueDateAlfredController')->except(['show']);
    Route::get('list_due_date_alfred/cari', 'Korsis\ListDueDateAlfredController@listcari')->name('list_due_date_alfred.listcari');
    Route::post('list_due_date_alfred/view', 'korsis\ListDueDateAlfredController@view')->name('list_due_date_alfred.view');
    Route::get('list_due_date_alfred/export', 'Korsis\ListDueDateAlfredController@export')->name('list_due_date_alfred/export.export');

    /** ######## Korsis DTS ######### */
    Route::resource('list_due_date_dts', 'Korsis\ListDueDateDtsController')->except(['show']);
    Route::get('list_due_date_dts/cari', 'Korsis\ListDueDateDtsController@listcari')->name('list_due_date_dts.listcari');
    Route::post('list_due_date_dts/view', 'korsis\ListDueDateDtsController@view')->name('list_due_date_dts.view');
    Route::get('list_due_date_dts/export', 'Korsis\ListDueDateDtsController@export')->name('list_due_date_dts/export.export');

    /** ######## Korsis Sukanda ######### */
    Route::resource('list_due_date_sukanda', 'Korsis\ListDueDateSukandaController')->except(['show']);
    Route::get('list_due_date_sukanda/cari', 'Korsis\ListDueDateSukandaController@listcari')->name('list_due_date_sukanda.listcari');
    Route::post('list_due_date_sukanda/view', 'korsis\ListDueDateSukandaController@view')->name('list_due_date_sukanda.view');
    Route::get('list_due_date_sukanda/export', 'Korsis\ListDueDateSukandaController@export')->name('list_due_date_sukanda/export.export');

    /** ######## Claim ######### */
    Route::resource('format_surat', 'Claim\SuratFormatController')->except(['show']);
    Route::post('format_surat/simpan', 'Claim\SuratFormatController@store')->name('format_surat/simpan.store');

    Route::resource('isi_surat', 'Claim\SuratIsiController')->except(['show']);
    Route::get('isi_surat/action_depo', 'Claim\SuratIsiController@actionDepo')->name('isi_surat/action_depo.actionDepo');
    Route::get('isi_surat/action_sku', 'Claim\SuratIsiController@actionSku')->name('isi_surat/action_sku.actionSku');
    Route::get('isi_surat/cari', 'Claim\SuratIsiController@cari')->name('isi_surat/cari.cari');
    Route::post('isi_surat/store', 'Claim\SuratIsiController@store')->name('isi_surat/store.store');
    Route::get('isi_surat/view/{no_urut}', 'Claim\SuratIsiController@view')->name('isi_surat/view.view');
    Route::get('isi_surat/pdf/{no_urut}', 'Claim\SuratIsiController@pdf')->name('isi_surat/pdf.pdf');
    Route::get('isi_surat/update/{no_urut}', 'Claim\SuratIsiController@update')->name('isi_surat/update.update');
    Route::post('isi_surat/edit', 'Claim\SuratIsiController@edit')->name('isi_surat/edit.edit');


    /** ######## Expenditure (Pengeluaran) ######### */
    Route::resource('petty_cash_ho', 'Expenditure\PcHoController')->except(['show']);
    Route::get('petty_cash_ho/cari', 'Expenditure\PcHoController@cari')->name('petty_cash_ho/cari.cari');

    Route::resource('rekap_pc_vs_cek', 'Expenditure\RekapPcVsCekController')->except(['show']);
    Route::resource('rekap_pc_vs_cek_total', 'Expenditure\RekapPcVsCekTotalController')->except(['show']);
    Route::resource('rekap_pc_rutin', 'Expenditure\RekapPcRutinController')->except(['show']);

    Route::resource('rekap_ops_rit_spp', 'Expenditure\RekapOpsRitSppController')->except(['show']);
    Route::resource('rekap_ops_rit_depo', 'Expenditure\RekapOpsRitSppRincianController')->except(['show']);

    Route::resource('rekap_weekly', 'Expenditure\RekapWeeklyController')->except(['show']);
    Route::resource('rekap_weekly_rincian', 'Expenditure\RekapWeeklyRincianController')->except(['show']);
    Route::resource('rekap_non_rutin', 'Expenditure\RekapBiayaNonRutinController')->except(['show']);

    /** ######## Supply Demand ######## */
    Route::resource('supply_demand', 'SupplyDemand\SupplyRequestController')->except(['show']);
    Route::get('supply_demand/cari', 'SupplyDemand\SupplyRequestController@cari')->name('supply_demand/cari.cari');
    Route::get('supply_demand/view/{kode_pesan}', 'SupplyDemand\SupplyRequestController@view')->name('supply_demand/view.view');
    Route::get('/supply_demand/action_product', 'SupplyDemand\SupplyRequestController@actionProduct')->name('supply_demand/action_product.actionProduct');
    Route::get('/ajax', 'SupplyDemand\SupplyRequestController@ajax');

    /** ######## Sparepart ######### */
    Route::resource('purchase_order', 'Sparepart\PurchaseOrderController')->except(['show']);
    Route::get('purchase_order/cari', 'Sparepart\PurchaseOrderController@cari')->name('purchase_order/cari.cari');
    Route::get('purchase_order/view/{part_purchase_order_h_code}', 'Sparepart\PurchaseOrderController@view')->name('purchase_order/view.view');
    Route::get('purchase_order/pdf/{part_purchase_order_h_code}', 'Sparepart\PurchaseOrderController@pdf')->name('purchase_order/pdf.pdf');

    Route::resource('kontrabon', 'Sparepart\KontraController')->except(['show']);
    Route::get('/kontrabon/action_vendor', 'Sparepart\KontraController@actionVendor')->name('kontrabon/action_vendor.actionVendor');
    Route::get('/kontrabon/action_invoice', 'Sparepart\KontraController@actionInvoice')->name('kontrabon/action_invoice.actionInvoice');
    Route::get('/kontrabon/action_invoice_tire', 'Sparepart\KontraController@actionInvoiceTire')->name('kontrabon/action_invoice_tire.actionInvoiceTire');
    Route::get('/kontrabon/view_detail/{no_kontrabon}', 'Sparepart\KontraController@view')->name('kontrabon/view_detail.view');
    Route::get('/kontrabon/pdf/{no_kontrabon}', 'Sparepart\KontraController@pdf')->name('kontrabon.kontrabon_pdf');

    Route::resource('vendor_sp', 'Sparepart\VendorSpController')->except(['show']); //master vendor
    Route::get('/vendor_sp/action_vendor', 'Sparepart\VendorSpController@actionVendor')->name('vendor_sp/action_vendor.actionVendor');
    Route::get('/vendor_sp/action_category', 'Sparepart\VendorSpController@actionKategori')->name('vendor_sp/action_category.actionKategori');

    Route::resource('vendor_category', 'Sparepart\VendorCatController')->except(['create', 'show']);

    /** ######## GetinGetOut ######### */
    Route::resource('getin_getout', 'GetinGetOut\GetInOutController')->except(['show']);
    Route::get('getin_getout/cari', 'GetinGetOut\GetInOutController@cari')->name('getin_getout/cari.cari');

//Route::resource('kredit', 'Rekon\KreditController')->except(['create','show']);
//Route::get('kredit/cari', 'Rekon\KreditController@rekeningcari')->name('kredit.rekeningcari');

    /** ######## Master harga sku aqua dan vit ######### */
    Route::resource('master_sku', 'Pembelian\MasterSkuController')->except(['show']);
    Route::get('master_sku/getDataSku', 'Pembelian\MasterSkuController@getDataSku')->name('master_sku/getDatasku.getDataSku');
    Route::post('master_sku/store', 'Pembelian\MasterSkuController@store')->name('master_sku/store.store');

    /** ######## Pembelian AQUA ######### */
    Route::resource('pembelian_aqua_otm', 'Pembelian\ImportPembelianAquaController')->except(['show']);
    Route::post('pembelian_aqua_otm/index', 'Pembelian\ImportPembelianAquaController@storeData')->name('pembelian_aqua_otm/index.storeData');

    Route::resource('list_pembelian_aqua', 'Pembelian\ListPembelianAquaController')->except(['show']);
    Route::get('list_pembelian_aqua/cari', 'Pembelian\ListPembelianAquaController@cari')->name('list_pembelian_aqua/cari.cari');

    Route::resource('permintaan_aqua', 'Pembelian\PermintaanAquaController')->except(['show']);
    Route::get('permintaan_aqua/cari', 'Pembelian\PermintaanAquaController@cari')->name('permintaan_aqua/cari.cari');
    Route::get('permintaan_aqua/cari_permintaan', 'Pembelian\PermintaanAquaController@cari_permintaan')->name('permintaan_aqua/cari_permintaan.cari_permintaan');
    Route::post('permintaan_aqua/store', 'Pembelian\PermintaanAquaController@store')->name('permintaan_aqua/store.store');

    Route::get('permintaan_aqua/{kode_pembelian}', 'Pembelian\PermintaanAquaController@view')->name('permintaan_aqua.view');
    Route::get('permintaan_aqua/accept/{kode_pembelian}', 'Pembelian\PermintaanAquaController@accept')->name('permintaan_aqua/accept.accept');
    Route::post('permintaan_aqua/accepted', 'Pembelian\PermintaanAquaController@accepted')->name('permintaan_aqua/accepted.accepted');


    /** ######## Pembelian VIT ######### */
    Route::resource('pembelian_vit_import', 'Pembelian\ImportPembelianVitController')->except(['show']);
    Route::post('/pembelian_vit_import/index', 'Pembelian\ImportPembelianVitController@storeData')->name('pembelian_vit_import/index.storeData');

    Route::resource('list_pembelian_vit', 'Pembelian\ListPembelianVitController')->except(['show']);
    Route::get('list_pembelian_vit/cari', 'Pembelian\ListPembelianVitController@cari')->name('list_pembelian_vit/cari.cari');

    Route::resource('monitoring_vit_gallon', 'Pembelian\MonitoringVitGallonController')->except(['show']);
    Route::get('monitoring_vit_gallon/cari', 'Pembelian\MonitoringVitGallonController@cari')->name('monitoring_vit_gallon/cari.cari');
    /** ######## --------------------------- ######### */

    /** ######## Import Tagihan TIV ######### */
    Route::resource('tagian_tiv_import', 'Pembelian\ImportTagihanController')->except(['show']);
    Route::post('tagian_tiv_import/index', 'Pembelian\ImportTagihanController@storeData')->name('tagian_tiv_import/index.storeData');

    Route::resource('list_tagihan_tiv', 'Pembelian\ListTagihanTivController')->except(['show']);
    Route::get('list_tagihan_tiv/cari', 'Pembelian\ListTagihanTivController@cari')->name('list_tagihan_tiv/cari.cari');

    /** ######## Tagihan AQUA & VIT ######### */
    Route::resource('tagihan_aqua_vit', 'Pembelian\TagihanController')->except(['show']);
    Route::get('tagihan_aqua_vit/cari', 'Pembelian\TagihanController@cari')->name('tagihan_aqua_vit/cari.cari');

    /** ######## Gudang In ######### */
    Route::resource('gudang_in', 'BarangMasuk_Gudang\GetInController')->except(['show']);
    Route::get('/export', 'BarangMasuk_Gudang\GetInController@export')->name('export.export');
    Route::get('gudang_in/cari', 'BarangMasuk_Gudang\GetInController@cari')->name('gudang_in/cari.cari');
    Route::get('/ajax_depo', 'BarangMasuk_Gudang\GetInController@ajax_depo');
    Route::get('gudang_in/{doc_id}', 'BarangMasuk_Gudang\GetInController@view')->name('gudang_in.view');

    Route::resource('gudang_in_check_control_history', 'BarangMasuk_Gudang\CheckControlHistoryController')->except(['show']);
    Route::get('gudang_in_check_control_history/cari', 'BarangMasuk_Gudang\CheckControlHistoryController@cari')->name('gudang_in_check_control_history/cari.cari');
    Route::get('/ajax_depo_gudang', 'BarangMasuk_Gudang\CheckControlHistoryController@ajax_depo_gudang');
    Route::get('gudang_in_check_control_history/{doc_id}', 'BarangMasuk_Gudang\CheckControlHistoryController@view')->name('gudang_in_check_control_history.view');

    Route::resource('gudang_stok_in', 'BarangMasuk_Gudang\StokInController')->except(['show']);
    Route::get('/ajax_zona', 'BarangMasuk_Gudang\StokInController@ajax_zona');
    Route::get('gudang_stok_in/cari', 'BarangMasuk_Gudang\StokInController@cari')->name('gudang_stok_in/cari.cari');

    Route::resource('check_control_Report_gudang_in', 'BarangMasuk_Gudang\CheckControlReportController')->except(['show']);
    Route::get('check_control_Report_gudang_in/cari', 'BarangMasuk_Gudang\CheckControlReportController@cari')->name('check_control_Report_gudang_in/cari.cari');
    Route::get('/ajax_depo_stok_gudang_in', 'BarangMasuk_Gudang\CheckControlReportController@ajax_depo_stok_gudang_in');


    /** ######## Gudang Out ######### */
    Route::resource('gudang_out', 'BarangKeluar_Gudang\GetOutController')->except(['show']);
    Route::get('gudang_out/cari', 'BarangKeluar_Gudang\GetOutController@cari')->name('gudang_out/cari.cari');
    Route::get('/ajax_depo_gudang_out', 'BarangKeluar_Gudang\GetOutController@ajax_depo_gudang_out');
    Route::get('gudang_out/{doc_id}', 'BarangKeluar_Gudang\GetOutController@view')->name('gudang_out.view');

    Route::resource('gudang_out_check_control_history', 'BarangKeluar_Gudang\CheckControlOutHistoryController')->except(['show']);
    Route::get('gudang_out_check_control_history/cari', 'BarangKeluar_Gudang\CheckControlOutHistoryController@cari')->name('gudang_out_check_control_history/cari.cari');
    Route::get('/ajax_depo_history_out', 'BarangKeluar_Gudang\CheckControlOutHistoryController@ajax_depo_history_out');
    Route::get('gudang_out_check_control_history/{doc_id}', 'BarangKeluar_Gudang\CheckControlOutHistoryController@view')->name('gudang_out_check_control_history.view');

    Route::resource('check_control_Report_gudang_out', 'BarangKeluar_Gudang\CheckControlReportController')->except(['show']);
    Route::get('check_control_Report_gudang_out/cari', 'BarangKeluar_Gudang\CheckControlReportController@cari')->name('check_control_Report_gudang_out/cari.cari');
    Route::get('/ajax_depo_stok_gudang_out', 'BarangKeluar_Gudang\CheckControlReportController@ajax_depo_stok_gudang_out');

    /** ######## Barang Masuk ######### */
    Route::resource('get_in', 'BarangMasuk\GetInController')->except(['show']);
    Route::get('get_in/action_product', 'BarangMasuk\GetInController@actionProduct')->name('get_in/action_product.actionProduct');
    Route::get('/ajax_zona_primary_layak', 'BarangMasuk\GetInController@ajax_zona_primary_layak');
    Route::get('/ajax_zona_primary_bs', 'BarangMasuk\GetInController@ajax_zona_primary_bs');
    Route::get('/ajax_zona_secondary_layak', 'BarangMasuk\GetInController@ajax_zona_secondary_layak');
    Route::get('/ajax_zona_secondary_bs', 'BarangMasuk\GetInController@ajax_zona_secondary_bs');
    Route::get('get_in/cari', 'BarangMasuk\GetInController@cari')->name('get_in/cari.cari');
    Route::get('get_in/{doc_id}', 'BarangMasuk\GetInController@view')->name('get_in.view');

    Route::resource('check_control_history', 'BarangMasuk\CheckControlHistoryController')->except(['show']);
    Route::get('check_control_history/cari', 'BarangMasuk\CheckControlHistoryController@cari')->name('check_control_history/cari.cari');
    Route::get('check_control_history/{doc_id}', 'BarangMasuk\CheckControlHistoryController@view')->name('check_control_history.view');

    Route::resource('check_control', 'BarangMasuk\CheckControlController')->except(['show']);
    Route::get('check_control/cari', 'BarangMasuk\CheckControlController@cari')->name('check_control/cari.cari');
    Route::get('check_control/{doc_id}', 'BarangMasuk\CheckControlController@view')->name('check_control.view');

    Route::resource('check_control_Report', 'BarangMasuk\CheckControlReportController')->except(['show']);
//Route::get('get_in/action_product','BarangMasuk\GetInController@actionProduct')->name('get_in/action_product.actionProduct');

    /** ######## Barang Keluar ######### */
    Route::resource('get_out', 'BarangKeluar\GetOutController')->except(['show']);
    Route::get('get_out/action_product_out', 'BarangKeluar\GetOutController@actionProductOut')->name('get_out/action_product_out.actionProductOut');
    Route::get('get_out/action_bkb', 'BarangKeluar\GetOutController@actionBkb')->name('get_out/action_bkb.actionBkb');
    Route::get('/ajax_zona_primary_layak_out', 'BarangKeluar\GetOutController@ajax_zona_primary_layak_out');
    Route::get('/ajax_zona_primary_bs_out', 'BarangKeluar\GetOutController@ajax_zona_primary_bs_out');
    Route::get('/ajax_zona_secondary_layak_out', 'BarangKeluar\GetOutController@ajax_zona_secondary_layak_out');
    Route::get('/ajax_zona_secondary_bs_out', 'BarangKeluar\GetOutController@ajax_zona_secondary_bs_out');
    Route::get('get_out/cari', 'BarangKeluar\GetOutController@cari')->name('get_out/cari.cari');
    Route::get('get_out/{doc_id}', 'BarangKeluar\GetOutController@view')->name('get_out.view');

    Route::resource('check_control_out_history', 'BarangKeluar\CheckControlOutHistoryController')->except(['show']);
    Route::get('check_control_out_history/cari', 'BarangKeluar\CheckControlOutHistoryController@cari')->name('check_control_out_history/cari.cari');
    Route::get('check_control_out_history/{doc_id}', 'BarangKeluar\CheckControlOutHistoryController@view')->name('check_control_out_history.view');

    Route::resource('check_control_out', 'BarangKeluar\CheckControlOutController')->except(['show']);
    Route::get('check_control_out/action_product', 'BarangKeluar\CheckControlOutController@actionProduct')->name('get_out/action_product.actionProduct');

    Route::get('check_control_out/cari', 'BarangKeluar\CheckControlOutController@cari')->name('check_control_out/cari.cari');
    Route::get('check_control_out/{doc_id}', 'BarangKeluar\CheckControlOutController@view')->name('check_control_out.view');

    Route::resource('check_control_Report_out', 'BarangKeluar\CheckControlReportOutController')->except(['show']);

    /** ######## Mutasi Getin Getout ######### */
    Route::resource('mutasi', 'Mutasi_Getinout\MutasiController')->except(['show']);
    Route::get('mutasi/cari', 'Mutasi_Getinout\MutasiController@cari')->name('mutasi/cari.cari');
    Route::get('mutasi/action_product', 'Mutasi_Getinout\MutasiController@actionProduct')->name('mutasi/action_product.actionProduct');
    Route::get('/ajax_zona_mutasi', 'Mutasi_Getinout\MutasiController@ajax_zona_mutasi');
    Route::get('/ajax_zona_mutasi_ke', 'Mutasi_Getinout\MutasiController@ajax_zona_mutasi_ke');
    Route::get('mutasi/{kode_mutasi}', 'Mutasi_Getinout\MutasiController@view')->name('mutasi.view');

    Route::resource('mutasi_internal_in', 'Mutasi_Getinout\MutasiInternal_In_Controller')->except(['show']);
    Route::get('mutasi_internal_in/{kode_mutasi}', 'Mutasi_Getinout\MutasiInternal_In_Controller@view')->name('mutasi_internal_in.view');

    Route::resource('mutasi_internal_leader', 'Mutasi_Getinout\MutasiInternalLeaderController')->except(['show']);
    Route::get('mutasi_internal_leader/cari', 'Mutasi_Getinout\MutasiInternalLeaderController@cari')->name('mutasi_internal_leader/cari.cari');
    Route::get('mutasi_internal_leader/{kode_mutasi}', 'Mutasi_Getinout\MutasiInternalLeaderController@view')->name('mutasi_internal_leader.view');
    Route::get('mutasi_internal_leader/approved/{kode_mutasi}', 'Mutasi_Getinout\MutasiInternalLeaderController@approved')->name('mutasi_internal_leader/approved');
    Route::get('mutasi_internal_leader/denied/{kode_mutasi}', 'Mutasi_Getinout\MutasiInternalLeaderController@denied')->name('mutasi_internal_leader/denied');

    Route::resource('mutasi_eksternal_leader', 'Mutasi_Getinout\MutasiEksternalLeaderController')->except(['show']);
    Route::get('mutasi_eksternal_leader/cari', 'Mutasi_Getinout\MutasiEksternalLeaderController@cari')->name('mutasi_eksternal_leader/cari.cari');
    Route::get('mutasi_eksternal_leader/{kode_mutasi_eks}', 'Mutasi_Getinout\MutasiEksternalLeaderController@view')->name('mutasi_eksternal_leader.view');
    Route::get('/ajax_zona_primary_eks', 'Mutasi_Getinout\MutasiEksternalLeaderController@ajax_zona_primary_eks');
    Route::get('/ajax_zona_secondary_eks', 'Mutasi_Getinout\MutasiEksternalLeaderController@ajax_zona_secondary_eks');
    Route::get('/ajax_perusahaan_primary_eks', 'Mutasi_Getinout\MutasiEksternalLeaderController@ajax_perusahaan_primary_eks');
    Route::get('/ajax_perusahaan_secondary_eks', 'Mutasi_Getinout\MutasiEksternalLeaderController@ajax_perusahaan_secondary_eks');

    Route::resource('mutasi_eksternal_in_leader', 'Mutasi_Getinout\MutasiEksternalLeaderInController')->except(['show']);
    Route::get('mutasi_eksternal_in_leader/cari', 'Mutasi_Getinout\MutasiEksternalLeaderInController@cari')->name('mutasi_eksternal_in_leader/cari.cari');
    Route::get('mutasi_eksternal_in_leader/{kode_mutasi_eks}', 'Mutasi_Getinout\MutasiEksternalLeaderInController@view')->name('mutasi_eksternal_in_leader.view');
    // Route::get('mutasi_eksternal_in_leader/approved/{kode_mutasi_eks}', 'Mutasi_Getinout\MutasiEksternalLeaderInController@approved')->name('mutasi_eksternal_in_leader/approved');
    Route::get('mutasi_eksternal_in_leader/denied/{kode_mutasi_eks}', 'Mutasi_Getinout\MutasiEksternalLeaderInController@denied')->name('mutasi_eksternal_in_leader/denied');
    Route::get('/ajax_zona_eksternal_in', 'Mutasi_Getinout\MutasiEksternalLeaderInController@ajax_zona_eksternal_in');

    Route::resource('mutasi_eksternal_in_checker', 'Mutasi_Getinout\MutasiEksternalCheckerInController')->except(['show']);
    Route::get('mutasi_eksternal_in_checker/cari', 'Mutasi_Getinout\MutasiEksternalCheckerInController@cari')->name('mutasi_eksternal_in_checker/cari.cari');
    Route::get('mutasi_eksternal_in_checker/{kode_mutasi_eks}', 'Mutasi_Getinout\MutasiEksternalCheckerInController@view')->name('mutasi_eksternal_in_checker.view');

    Route::resource('mutasi_eksternal_out_checker', 'Mutasi_Getinout\MutasiEksternalCheckerOutController')->except(['show']);
    Route::get('mutasi_eksternal_out_checker/cari', 'Mutasi_Getinout\MutasiEksternalCheckerOutController@cari')->name('mutasi_eksternal_out_checker/cari.cari');
    Route::get('mutasi_eksternal_out_checker/{kode_mutasi_eks}', 'Mutasi_Getinout\MutasiEksternalCheckerOutController@view')->name('mutasi_eksternal_out_checker.view');

    /** ######## LOGISTIK ######### */
    Route::resource('logistik_uang_rit', 'Logistik\UangRitController')->except(['show']);
    Route::get('logistik/getDataUangRit', 'Logistik\UangRitController@getDataUangRit')->name('logistik/getDataUangRit.getDataUangRit');
    Route::get('logistik/getDataDetail', 'Logistik\UangRitController@getDataDetail')->name('logistik/getDataDetail.getDataDetail');
    Route::post('logistik/store', 'Logistik\UangRitController@store')->name('logistik/store.store');
    Route::post('logistik/update', 'Logistik\UangRitController@update')->name('logistik/update.update');
    Route::get('logistik/getData', 'Logistik\UangRitController@getData')->name('logistik/getData');
    // routes/web.php
    Route::get('logistik/getDataProduk', 'Logistik\UangRitController@getDataProduk')->name('logistik.getDataProduk');
    Route::get('logistik/getDataDesitnasi', 'Logistik\UangRitController@getDataDestinasi')->name('logistik.getDataDestinasi');
    Route::get('logistik/getDataPabrik', 'Logistik\UangRitController@getDataPabrik')->name('logistik.getDataPabrik');



    /** ######## SND ######### */
    Route::resource('snd_import', 'Snd\SndImportController')->except(['show']);
    // Route::resource('snd_import_data', 'Snd\SndImportController')->except(['show']);

    Route::resource('format_surat_program_eks', 'Snd\Surat_eksternal\SuratFormatController')->except(['show']);
    Route::post('format_surat_program_eks/simpan', 'Snd\Surat_eksternal\SuratFormatController@store')->name('format_surat_program_eks/simpan.store');

    Route::resource('isi_surat_program_ek', 'Snd\Surat_eksternal\SuratIsiController')->except(['show']);

    Route::resource('upload_kirim_surat', 'Snd\UploadKirimController')->except(['show']);
    //Route::get('upload_kirim_surat/{column}/{order}', 'Snd\UploadKirimController@sort')->name('sort');
    Route::get('upload_kirim_surat/cari', 'Snd\UploadKirimController@cari')->name('upload_kirim_surat/cari.cari');
    Route::get('upload_kirim_surat/view_app/{no_urut}', 'Snd\UploadKirimController@view_approve')->name('upload_kirim_surat/view_app.view_approve');
    Route::get('upload_kirim_surat/penerima/{no_urut}', 'Snd\UploadKirimController@view_terima_surat')->name('upload_kirim_surat/penerima.view_terima_surat');
    Route::post('upload_kirim_surat/ajax/store', 'Snd\UploadKirimController@store')->name('upload_kirim_surat/ajax/store.store');
    Route::get('upload_kirim_surat/{no_urut}', 'Snd\UploadKirimController@view')->name('upload_kirim_surat.view');
    Route::get('upload_kirim_surat_edit/{no_urut}', 'Snd\UploadKirimController@edit')->name('upload_kirim_surat_edit.edit');
    Route::get('approval-surat-program-update/{no_urut}', 'Snd\UploadKirimController@approved')->name('approval-surat-program-update');
    Route::get('approval-surat-program-denied/{no_urut}', 'Snd\UploadKirimController@denied')->name('approval-surat-program-denied');
    Route::post('/approval_surat_program/{no_urut}', 'Snd\UploadKirimController@pdf_app')->name('approval_surat_program.pdf_app');
    Route::post('/view-excel', 'Snd\UploadKirimController@viewExcel')->name('view-excel');
    Route::post('/view-word', 'Snd\UploadKirimController@viewWord')->name('view-word');

    Route::resource('upload_kirim_surat_history', 'Snd\UploadKirimHistoryController')->except(['show']);
    //Route::get('upload_kirim_surat_history/{column}/{order}', 'Snd\UploadKirimHistoryController@sort')->name('sort');
    Route::get('upload_kirim_surat_history/cari', 'Snd\UploadKirimHistoryController@cari')->name('upload_kirim_surat_history/cari.cari');
    Route::get('upload_kirim_surat_history/{no_urut}', 'Snd\UploadKirimHistoryController@view')->name('upload_kirim_surat_history.view');
    Route::get('upload_kirim_surat_history/update_data/{no_urut}', 'Snd\UploadKirimHistoryController@update_data')->name('upload_kirim_surat_history/update_data');

    Route::resource('data_upload_dtc', 'Snd\UploadDataDtcController')->except(['show']);
    Route::get('data_upload_dtc/cari', 'Snd\UploadDataDtcController@cari')->name('data_upload_dtc/cari.cari');

    Route::resource('import_pencapaian', 'Snd\ImportPencapaianController')->except(['show']);
    Route::get('import_pencapaian/cari', 'Snd\ImportPencapaianController@cari')->name('import_pencapaian/cari.cari');
    Route::get('import_pencapaian/action', 'Snd\ImportPencapaianController@actionSuratProgram')->name('import_pencapaian/action.actionSuratProgram');
    Route::post('import_pencapaian/import', 'Snd\ImportPencapaianController@store')->name('import_pencapaian/import.store');
    Route::get('import_pencapaian/{no_urut}', 'Snd\ImportPencapaianController@view')->name('import_pencapaian.view');
    Route::get('import_pencapaian/update_data/{no_urut}', 'Snd\ImportPencapaianController@update_data')->name('import_pencapaian/update_data');
    Route::post('import_pencapaian/edit', 'Snd\ImportPencapaianController@edit')->name('import_pencapaian/edit.edit');

    Route::resource('rekening_outlet', 'Snd\RekeningOutletController')->except(['show']);
    Route::get('rekening_outlet/getDataRekening', 'Snd\RekeningOutletController@getDataRekening')->name('rekening_outlet/getDataRekening.getDataRekening');
    Route::get('/ajax_depo_rekening', 'Snd\RekeningOutletController@ajax_depo_rekening');
    Route::post('rekening_outlet/store', 'Snd\RekeningOutletController@store')->name('rekening_outlet/store.store');
    Route::get('rekening_outlet/getDataRekeningDetail', 'Snd\RekeningOutletController@getDataRekeningDetail')->name('rekening_outlet/getDataRekeningDetail.getDataRekeningDetail');
    Route::post('rekening_outlet/update', 'Snd\RekeningOutletController@update')->name('rekening_outlet/update.update');
    Route::get('rekening_outlet/view', 'Snd\RekeningOutletController@view_excel')->name('rekening_outlet/view.view_excel');

    /** ######## QR Code ######### */
    Route::resource('qr_code', 'DataQrController')->except(['show']);
    Route::get('qr_code/cari', 'DataQrController@cari')->name('qr_code/cari.cari');
    Route::post('qr_code/edit', 'DataQrController@edit')->name('qr_code/edit.edit');
    Route::get('qr_code/{id}', 'DataQrController@generate')->name('generate');
    Route::get('qr_code/update/{id}', 'DataQrController@update')->name('qr_code/update');
    Route::get('qr_code/pdf/{kode}', 'DataQrController@pdf')->name('qr_code.pdf');

    Route::get('qr_code/view/{kode}', 'DataQrController@view')->name('qr_code.view');

    /** ######## GA (General Affair) ######### */
    Route::resource('rab', 'Ga\RabController')->except(['show']);
    Route::get('rab/action_rab', 'Ga\RabController@actionRab')->name('rab/action_rab.actionRab');

    /** ######## Data Center ################# */
    Route::resource('data_center_dms', 'DataCenter\DataDmsController')->except(['show']);
    Route::get('data_center_dms/cari', 'DataCenter\DataDmsController@cari')->name('data_center_dms/cari.cari');
    Route::post('data_center_dms/import', 'DataCenter\DataDmsController@storeDataDms')->name('data_center_dms/import.storeDataDms');

    /** ######## Laporan-Laporan ######### */
    Route::resource('l_checker_gudang', 'Laporan\Gudang\CheckerGudangController')->except(['show']);
    Route::get('/ajax_depo_laporan', 'Laporan\Gudang\CheckerGudangController@ajax_depo_laporan');
    Route::get('/ajax_checker_laporan', 'Laporan\Gudang\CheckerGudangController@ajax_checker_laporan');
    // Route::get('/ajax_checker_type_laporan', 'Laporan\Gudang\CheckerGudangController@ajax_checker_type_laporan');
    Route::get('l_checker_gudang/cari', 'Laporan\Gudang\CheckerGudangController@cari')->name('l_checker_gudang/cari.cari');

    Route::resource('l_checker_gudang_bs', 'Laporan\Gudang\CheckerGudangControllerBs')->except(['show']);
    Route::get('/ajax_depo_laporan_bs', 'Laporan\Gudang\CheckerGudangControllerBs@ajax_depo_laporan_bs');
    Route::get('/ajax_checker_laporan_bs', 'Laporan\Gudang\CheckerGudangControllerBs@ajax_checker_laporan_bs');
    // Route::get('/ajax_checker_type_laporan', 'Laporan\Gudang\CheckerGudangController@ajax_checker_type_laporan');
    Route::get('l_checker_gudang_bs/cari', 'Laporan\Gudang\CheckerGudangControllerBs@cari')->name('l_checker_gudang_bs/cari.cari');

    Route::resource('l_get_in', 'Laporan\Gudang\LaporanGetInController')->except(['show']);
    Route::get('/ajax_depo_laporan_getin', 'Laporan\Gudang\LaporanGetInController@ajax_depo_laporan_getin');
    Route::get('l_get_in/cari', 'Laporan\Gudang\LaporanGetInController@cari')->name('l_get_in/cari.cari');
    Route::post('l_get_in/view', 'Laporan\Gudang\LaporanGetInController@view')->name('l_get_in/view.view');

    //akunting
    Route::resource('laporan_biaya_jasa', 'Laporan\Akunting\PengajuanBiayaController')->except(['show']);
    Route::get('laporan_biaya_jasa/ajax_depo', 'Laporan\Akunting\PengajuanBiayaController@ajax_depo');
    Route::get('laporan_biaya_jasa/view', 'Laporan\Akunting\PengajuanBiayaController@view_excel')->name('laporan_biaya_jasa/view.view_excel');

    Route::resource('laporan_spp', 'Laporan\Akunting\lapSppController')->except(['show']);
    Route::get('laporan_spp/ajax_depo', 'Laporan\Akunting\lapSppController@ajax_depo');
    Route::get('laporan_spp/view', 'Laporan\Akunting\lapSppController@view_excel')->name('laporan_spp/view.view_excel');

    //GA
    Route::resource('laporan_pengajuan', 'Laporan\Ga\LapPengajuanController')->except(['show']);
    Route::get('laporan_pengajuan/ajax_depo', 'Laporan\Ga\LapPengajuanController@ajax_depo');
    Route::get('laporan_pengajuan/view', 'Laporan\Ga\LapPengajuanController@view_excel')->name('laporan_pengajuan/view.view_excel');

    Route::resource('laporan_pengajuan_perbarang', 'Laporan\Ga\LapPengajuanPerbarangController')->except(['show']);
    Route::get('laporan_pengajuan_perbarang/ajax_depo', 'Laporan\Ga\LapPengajuanPerbarangController@ajax_depo');
    Route::get('laporan_pengajuan_perbarang/view', 'Laporan\Ga\LapPengajuanPerbarangController@view_excel')->name('laporan_pengajuan_perbarang/view.view_excel');

    /** ######## BOD 2 ################# */
    Route::resource('bod_monitoring', 'Bod_2\MonitoringSaldoController')->except(['show']);
    Route::post('bod_monitoring/cari', 'Bod_2\MonitoringSaldoController@cari')->name('bod_monitoring/cari');
    Route::get('bod_monitoring/jugs', 'Bod_2\MonitoringSaldoController@skujugs')->name('bod_monitoring/jugs');
    Route::get('bod_monitoring/sps', 'Bod_2\MonitoringSaldoController@skusps')->name('bod_monitoring/sps');
    Route::get('bod_monitoring/iod', 'Bod_2\MonitoringSaldoController@iod')->name('bod_monitoring/iod');
    Route::get('bod_monitoring/afh', 'Bod_2\MonitoringSaldoController@afh')->name('bod_monitoring/afh');
    Route::get('bod_monitoring/ahs', 'Bod_2\MonitoringSaldoController@ahs')->name('bod_monitoring/ahs');
    Route::get('bod_monitoring/mt', 'Bod_2\MonitoringSaldoController@mt')->name('bod_monitoring/mt');
    Route::get('bod_monitoring/retail', 'Bod_2\MonitoringSaldoController@retail')->name('bod_monitoring/retail');
    Route::get('bod_monitoring/so', 'Bod_2\MonitoringSaldoController@so')->name('bod_monitoring/so');
    Route::get('bod_monitoring/ws', 'Bod_2\MonitoringSaldoController@ws')->name('bod_monitoring/ws');

    Route::resource('bod_akunting', 'Bod_2\MonitoringAkuntingController')->except(['show']);
    Route::resource('bod_penjualan', 'Bod_2\PenjualanController')->except(['show']);

    //-----------------daily_activity SOM--------------------------------------------------------------------
    Route::resource('daily_activity_som', 'DailyActivitySom\DailyActivitySomController')->except(['create', 'show']);
    Route::post('daily_activity_som/store', 'DailyActivitySom\DailyActivitySomController@store')->name('daily_activity_som/store.store');
    Route::get('daily_activity_som/view_list', 'DailyActivitySom\DailyActivitySomController@view_list')->name('daily_activity_som/view_list.view_list');
    Route::get('daily_activity_som/view/{id}', 'DailyActivitySom\DailyActivitySomController@view')->name('daily_activity_som/view.view');
    Route::post('daily_activity_som/update', 'DailyActivitySom\DailyActivitySomController@update')->name('daily_activity_som/update.update');
    Route::post('daily_activity_som/modalDetail', 'DailyActivitySom\DailyActivitySomController@modalDetail')->name('daily_activity_som/detail');

    //-----------------daily_activity SSD--------------------------------------------------------------------
    Route::resource('daily_activity_ssd', 'DailyActivitySsd\DailyActivitySsdController')->except(['create', 'show']);
    Route::post('daily_activity_ssd/store', 'DailyActivitySsd\DailyActivitySsdController@store')->name('daily_activity_ssd/store.store');
    Route::get('daily_activity_ssd/view_list', 'DailyActivitySsd\DailyActivitySsdController@view_list')->name('daily_activity_ssd/view_list.view_list');
    Route::get('daily_activity_ssd/view/{id}', 'DailyActivitySsd\DailyActivitySsdController@view')->name('daily_activity_ssd/view.view');

    //-----------------daily_activity ASM--------------------------------------------------------------------
    Route::resource('daily_activity_asm', 'DailyActivityAsm\DailyActivityAsmController')->except(['create', 'show']);
    Route::post('daily_activity_asm/store', 'DailyActivityAsm\DailyActivityAsmController@store')->name('daily_activity_asm/store.store');
    Route::post('daily_activity_asm/create', 'DailyActivityAsm\DailyActivityAsmController@create')->name('daily_activity_asm/create.create');
    Route::post('daily_activity_asm/store', 'DailyActivityAsm\DailyActivityAsmController@daily_activity_asm')
        ->name('daily_activity_asm.daily_activity_asm.store');
    Route::get('daily_activity_asm/view_list', 'DailyActivityAsm\DailyActivityAsmController@view_list')->name('daily_activity_asm/view_list.view_list');
    Route::get('daily_activity_asm/view/{id}', 'DailyActivityAsm\DailyActivityAsmController@view')->name('daily_activity_asm/view.view');
    Route::post('daily_activity_asm/update', 'DailyActivityAsm\DailyActivityAsmController@update')->name('daily_activity_asm/update.update');
    Route::post('daily_activity_asm/modalDetail', 'DailyActivityAsm\DailyActivityAsmController@modalDetail')->name('daily_activity_asm/detail');

    //-----------------daily_activity KPJ--------------------------------------------------------------------
    Route::resource('daily_activity_kpj', 'DailyActivityKpj\DailyActivityKpjController')->except(['create', 'show']);
    Route::post('daily_activity_kpj/store', 'DailyActivityKpj\DailyActivityKpjController@store')->name('daily_activity_kpj.store');
    Route::get('daily_activity_kpj/view_list', 'DailyActivityKpj\DailyActivityKpjController@view_list')->name('daily_activity_kpj/view_list.view_list');
    Route::get('daily_activity_kpj/view/{id}', 'DailyActivityKpj\DailyActivityKpjController@view')->name('daily_activity_kpj/view.view');
    Route::post('daily_activity_kpj/modalDetail', 'DailyActivityKpj\DailyActivityKpjController@modalDetail')->name('daily_activity_kpj/detail');


    //-----------------daily_activity--------------------------------------------------------------------
    Route::resource('daily_activity', 'DailyActivity\DailyActivityController')->except(['create', 'show']);
    Route::post('daily_activity/', 'DailyActivity\DailyActivityController@index')->name('daily_activity.index');
    Route::post('daily_activity/store', 'DailyActivity\DailyActivityController@store')->name('daily_activity/store.store');
    Route::get('daily_activity/view_list', 'DailyActivity\DailyActivityController@view_list')->name('daily_activity/view_list.view_list');
    Route::get('daily_activity/view/{id}', 'DailyActivity\DailyActivityController@view')->name('daily_activity/view.view');
    Route::get('daily_activity/dashboard_area_dom', 'DailyActivity\DailyActivityController@dashboardAreaDom')->name('daily_activity.dashboard_area');
    Route::post('daily_activity/dashboard_area_dom/data', 'DailyActivity\DailyActivityController@dashboardAreaDomData')->name('daily_activity.dashboard_area.data');

    //-----------------HRD Remun--------------------------------------------------------------------
    Route::resource('karyawan', 'Hrd\Karyawan\KaryawanController')->except(['create', 'show']);
    Route::get('karyawan/data', 'Hrd\Karyawan\KaryawanController@data')->name('karyawan.data');
    Route::get('karyawan/create', 'Hrd\Karyawan\KaryawanController@create')->name('karyawan/create.create');
    Route::post('karyawan/store', 'Hrd\Karyawan\KaryawanController@store')->name('karyawan/store.store');

    Route::resource('tunjangan', 'Hrd\Tunjangan\TunjanganController')->except(['create', 'show']);
    Route::get('tunjangan/data', 'Hrd\Tunjangan\TunjanganController@data')->name('tunjangan.data');
    Route::get('tunjangan/create', 'Hrd\Tunjangan\TunjanganController@create')->name('tunjangan/create.create');
    Route::post('tunjangan/store', 'Hrd\Tunjangan\TunjanganController@store')->name('tunjangan/store.store');

    Route::resource('remun', 'Hrd\Remun\RemunController')->except(['create', 'show']);
    Route::get('remun/create', 'Hrd\Remun\RemunController@create')->name('remun/create.create');
    Route::get('remun/cari', 'Hrd\Remun\RemunController@cari')->name('remun/cari.cari');
    Route::get('remun/action_karyawan', 'Hrd\Remun\RemunController@actionKaryawan')->name('remun/action_karyawan.actionKaryawan');
    Route::get('remun/action_tunjangan', 'Hrd\Remun\RemunController@actionTunjangan')->name('remun/action_tunjangan.actionTunjangan');
    Route::post('remun/simpan', 'Hrd\Remun\RemunController@store')->name('remun/simpan.store');
    Route::get('remun/index', 'Hrd\Remun\RemunController@index')->name('remun/index.index');
    Route::get('remun/view/{no_ptk}', 'Hrd\Remun\RemunController@view')->name('remun/view.view');
    Route::get('remun/pdf/{no_ptk}', 'Hrd\Remun\RemunController@pdf')->name('remun/pdf.pdf');
    Route::post('remun/approved', 'Hrd\Remun\RemunController@approved')->name('remun/approved.approved');
    Route::post('remun/denied', 'Hrd\Remun\RemunController@denied')->name('remun/denied.denied');
    Route::post('remun/pending', 'Hrd\Remun\RemunController@pending')->name('remun/pending.pending');
    Route::get('remun/update/{no_ptk}', 'Hrd\Remun\RemunController@update')->name('remun/update.update');
    Route::post('remun/edit', 'Hrd\Remun\RemunController@edit')->name('remun/edit.edit');

    //-----------------CONTOH--------------------------------------------------------------------
    Route::resource('tabledit', 'TableditController')->except(['create', 'show']);
    Route::post('tabledit/action', 'TableditController@action')->name('tabledit.action');

    Route::resource('penjualan', 'Backend\PenjualanController');

    Route::resource('settlement', 'Settlement\SettlementController')->except(['show']);
});
