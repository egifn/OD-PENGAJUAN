<?php

namespace App\Http\Controllers\Bod_2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Perusahaan;

class MonitoringAkuntingController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        $monitoring = DB::connection('mysql_ta')
            ->select("
                SELECT
                data.TANGGAL,
                SUM(CASE WHEN CATEGORY = 'Penjualan_Tunai' THEN NILAI ELSE 0 END) AS 'Penjualan_Tunai',
                SUM(CASE WHEN CATEGORY = 'Penjualan_Tunai_Transfer' THEN NILAI ELSE 0 END) AS 'Penjualan_Tunai_Transfer',
                SUM(CASE WHEN CATEGORY = 'Tagihan_Tunai' THEN NILAI ELSE 0 END) AS 'Tagihan_Tunai',
                SUM(CASE WHEN CATEGORY = 'Setoran_Penjualan_Tunai' THEN NILAI ELSE 0 END) AS 'Setoran_Penjualan_Tunai',
                SUM(CASE WHEN CATEGORY = 'Setoran_Tagihan_Tunai' THEN NILAI ELSE 0 END) AS 'Setoran_Tagihan_Tunai',
                SUM(CASE WHEN CATEGORY = 'Setoran_Tagihan_Non_Tunai' THEN NILAI ELSE 0 END) AS 'Setoran_Tagihan_Non_Tunai',
                SUM(CASE WHEN CATEGORY = 'Penerimaan_Setoran_Tagihan_Non_Tunai' THEN NILAI ELSE 0 END) AS 'Penerimaan_Setoran_Tagihan_Non_Tunai',
                SUM(CASE WHEN CATEGORY = 'Penerimaan_Setoran_Penjualan_Tunai' THEN NILAI ELSE 0 END) AS 'Penerimaan_Setoran_Penjualan_Tunai',
                SUM(CASE WHEN CATEGORY = 'Penerimaan_Setoran_Tagihan_Tunai' THEN NILAI ELSE 0 END) AS 'Penerimaan_Setoran_Tagihan_Tunai',
                SUM(CASE WHEN CATEGORY = 'Pengeluaran_Petty_Cash' THEN NILAI ELSE 0 END) AS 'Pengeluaran_Petty_Cash',
                SUM(CASE WHEN CATEGORY = 'Penerimaan_Petty_Cash' THEN NILAI ELSE 0 END) AS 'Penerimaan_Petty_Cash',
                SUM(CASE WHEN CATEGORY = 'Tagihan_Non_Tunai' THEN NILAI ELSE 0 END) AS 'Tagihan_Non_Tunai',
                SUM(CASE WHEN CATEGORY = 'Pengeluaran_Biaya' THEN NILAI ELSE 0 END) AS 'Pengeluaran_Biaya'
            FROM (
                SELECT
            cashout.szBranchId AS 'ID_DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
            branch.szCompanyId AS 'ENTITAS',
            cashoutItem.szDocId AS 'NO_DOK',
            DATE(cashout.dtmDoc) AS 'TANGGAL',
            DAY(cashout.dtmDoc) AS 'HARI',
            MONTH(cashout.dtmDoc) AS 'BULAN',
            YEAR(cashout.dtmDoc) AS 'TAHUN',
            cashout.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA SALES',
            cashout.szAccountId AS 'NO-AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            cashoutItem.szAccountId AS 'NO-AKUN2',
            account2.szName AS 'NAMA_AKUN2',
            CASE
            WHEN account2.szName = 'HPT' AND cashOut.szAccountId = '110000' THEN 'Penjualan_Tunai'
            WHEN account2.szName IN ('HPT KOPO','HPT LODAYA') AND cashOut.szAccountId = '110000' THEN 'Penjualan_Tunai'
            WHEN account2.szName = 'HPT' AND cashOut.szAccountId = '140000' THEN 'Penjualan_Tunai_Transfer'
            WHEN account2.szName = 'HTT' AND cashOut.szAccountId = '110000' THEN 'Tagihan_Tunai'
            WHEN account2.szName = 'SPT' AND cashOut.szAccountId = '110000' THEN 'Setoran_Penjualan_Tunai'
            WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashOut.szAccountId = '110000' THEN 'Setoran_Penjualan_Tunai'
            WHEN account2.szName = 'STT' AND cashOut.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'HTC' AND cashOut.szAccountId = '110000' THEN 'Tagihan_Tunai'
            WHEN account2.szName = 'BIAYA TRANSFER' AND cashOut.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'BIAYA ADMIN BANK' AND cashOut.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'BIAYA MATERAI' AND cashOut.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'STC' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan_Non_Tunai'
            WHEN account2.szName = 'STC' AND cashOut.szAccountId = '140000' THEN 'Penerimaan_Setoran_Tagihan_Non_Tunai'
            WHEN account2.szName = 'SPT' AND cashOut.szAccountId = '140000' THEN 'Penerimaan_Setoran_Penjualan_Tunai'
            WHEN account2.szName = 'STT' AND cashOut.szAccountId = '140000' THEN 'Penerimaan_Setoran_Tagihan_Tunai'
            WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashOut.szAccountId = '140000' THEN 'Penerimaan_Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'KAS KE KAS' AND cashOut.szAccountId = '110000' THEN 'Pengeluaran_Petty_Cash'
            ELSE 'Other' END AS 'CATEGORY',

            CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
            'BKU1' AS 'TRANSASKI'

            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId =outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            INNER JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId

            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20')
            AND cashout.szBranchId = '260'
            AND cashout.szAccountId IN ('110000','140000')
            UNION ALL
            SELECT
            cashin.szBranchId AS 'ID DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
            branch.szCompanyId AS 'ENTITAS',
            cashinItem.szDocId AS 'NO_DOK',
            DATE(cashIn.dtmDoc) AS 'TANGGAL',
            DAY(cashin.dtmDoc) AS 'HARI',
            MONTH(cashin.dtmDoc) AS 'BULAN',
            YEAR(cashin.dtmDoc) AS 'TAHUN',
            cashin.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA_SALES',
            cashin.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            cashinItem.szAccountId AS 'NO_AKUN2',
            account2.szName AS 'NAMA_AKUN2',
            CASE
            WHEN account2.szName = 'HPT' AND cashIn.szAccountId = '110000' THEN 'Penjualan_Tunai'
            WHEN account2.szName IN ('HPT KOPO','HPT LODAYA') AND cashIn.szAccountId = '110000' THEN 'Penjualan_Tunai'
            WHEN account2.szName = 'HPT' AND cashIn.szAccountId = '140000' THEN 'Penjualan-Tunai_Transfer'
            WHEN account2.szName = 'HTT' AND cashIn.szAccountId = '110000' THEN 'Tagihan_Tunai'
            WHEN account2.szName = 'SPT' AND cashIn.szAccountId = '110000' THEN 'Setoran_Penjualan_Tunai'
            WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashIn.szAccountId = '110000' THEN 'Setoran_Penjualan_Tunai'
            WHEN account2.szName = 'STT' AND cashIn.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'HTC' AND cashIn.szAccountId = '110000' THEN 'Tagihan_Tunai'
            WHEN account2.szName = 'BIAYA TRANSFER' AND cashIn.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'BIAYA ADMIN BANK' AND cashIn.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'BIAYA MATERAI' AND cashIn.szAccountId = '110000' THEN 'Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'STC' AND cashIn.szAccountId = '110000' THEN 'Setoran_Tagihan_Non_Tunai'
            WHEN account2.szName = 'STC' AND cashIn.szAccountId = '140000' THEN 'Penerimaan_Setoran_Tagihan_Non_Tunai'
            WHEN account2.szName = 'SPT' AND cashIn.szAccountId = '140000' THEN 'Penerimaan_Setoran_Penjualan_Tunai'
            WHEN account2.szName = 'STT' AND cashIn.szAccountId = '140000' THEN 'Penerimaan_Setoran_Tagihan_Tunai'
            WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashIn.szAccountId = '140000' THEN 'Penerimaan_Setoran_Tagihan_Tunai'
            WHEN account2.szName = 'KAS KE KAS' AND cashIn.szAccountId = '110000' THEN 'Pengeluaran_Petty_Cash'
            ELSE 'Other' END AS 'CATEGORY',
            CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
            'BTU1' AS 'TRANSAKSI'

            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            INNER JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId

            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20')
            AND cashin.szBranchId = '260'
            AND cashIn.szAccountId IN ('110000','140000')
            UNION ALL
            SELECT
            cashout.szBranchId AS 'ID DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
            branch.szCompanyId AS 'ENTITAS',
            cashoutItem.szDocId AS 'NO_DOK',
            DATE(cashout.dtmDoc) AS 'TANGGAL',
            DAY(cashout.dtmDoc) AS 'HARI',
            MONTH(cashout.dtmDoc) AS 'BULAN',
            YEAR(cashout.dtmDoc) AS 'TAHUN',
            cashout.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA_SALES',
            cashout.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            cashoutItem.szAccountId AS 'NO_AKUN2',
            account2.szName AS 'NAMA_AKUN2',
            CASE
            WHEN account2.szName = 'STC' AND cashOut.szAccountId NOT LIKE '140000' THEN 'Setoran_Tagihan_Non_Tunai'
            ELSE 'Other' END AS 'CATEGORY',
            CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
            'BKU2' AS 'TRANSASKI'

            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId =outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            INNER JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId

            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20')
            AND cashout.szBranchId = '260'
            AND cashoutItem.szAccountId = '140103'
            AND cashOut.szAccountId NOT LIKE '110000'
            AND (account2.szName = 'STC' AND cashOut.szAccountId NOT LIKE '140000')
            UNION ALL
            SELECT
            cashin.szBranchId AS 'ID DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName,'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
            branch.szCompanyId AS 'ENTITAS',
            cashinItem.szDocId AS 'NO_DOK',
            DATE(cashIn.dtmDoc) AS 'TANGGAL',
            DAY(cashin.dtmDoc) AS 'HARI',
            MONTH(cashin.dtmDoc) AS 'BULAN',
            YEAR(cashin.dtmDoc) AS 'TAHUN',
            cashin.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA_SALES',
            cashin.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            cashinItem.szAccountId AS 'NO_AKUN2',
            account2.szName AS 'NAMA_AKUN2',
            CASE
            WHEN account2.szName = 'STC' AND cashIn.szAccountId NOT LIKE '140000' THEN 'Setoran_Tagihan_Non_Tunai'
            ELSE 'Other' END AS 'CATEGORY',
            CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
            'BTU2' AS 'TRANSAKSI'

            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            INNER JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId

            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20')
            AND cashin.szBranchId = '260'
            AND cashInItem.szAccountId = '140103'
            AND cashin.szAccountId NOT LIKE '110000'
            AND (account2.szName = 'STC' AND cashIn.szAccountId NOT LIKE '140000')
            UNION ALL
            SELECT
            clearing.szBranchId AS 'ID_DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
            branch.szCompanyId AS 'ENTITAS',
            '' AS 'NO_DOK',
            DATE(clearing.dtmDoc) AS 'TANGGAL',
            DAY(clearing.dtmDoc) AS 'HARI',
            MONTH(clearing.dtmDoc) AS 'BULAN',
            YEAR(clearing.dtmDoc) AS 'TAHUN',
            bg.szEmployeeId AS 'ID_SALESMAN',
            employee.szName AS 'NAMA_SALESMAN',
            '' AS 'NO_AKUN1',
            '' AS 'NAMA_AKUN1',
            '' AS 'NO_AKUN2',
            '' AS 'NAMA_AKUN2',
            'Tagihan_Non_Tunai' AS 'CATEGORY',
            CAST(SUM(bg.decAmount) AS DECIMAL) AS 'NILAI',
            'CLEARING' AS 'TRANSAKSI'

            FROM dms_cas_docbgclearing AS clearing
            INNER JOIN dms_sm_branch AS branch ON clearing.szBranchId = branch.szId
            INNER JOIN dms_cas_docBgClearingItem AS clearingItem ON clearing.szDocId = clearingItem.szDocId
            INNER JOIN dms_cas_bg AS bg ON clearingItem.szRefDocId = bg.szId
            INNER JOIN dms_pi_employee AS employee ON bg.szEmployeeId = employee.szId

            WHERE clearing.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20'
            AND clearing.szBranchId = '260'

            GROUP BY clearing.szBranchId, DATE(clearing.dtmDoc), DAY(clearing.dtmDoc), MONTH(clearing.dtmDoc), YEAR(clearing.dtmDoc), bg.szEmployeeId, employee.szName


            UNION ALL
            SELECT
            cashout.szBranchId AS 'ID_DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
            branch.szCompanyId AS 'ENTITAS',
            cashoutItem.szDocId AS 'NO_DOK',
            DATE(cashout.dtmDoc) AS 'TANGGAL',
            DAY(cashout.dtmDoc) AS 'HARI',
            MONTH(cashout.dtmDoc) AS 'BULAN',
            YEAR(cashout.dtmDoc) AS 'TAHUN',
            cashout.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA SALES',
            cashout.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            cashoutItem.szAccountId AS 'NO_AKUN2',
            account2.szName AS 'NAMA_AKUN2',
            'Penerimaan Petty Cash' AS 'CATEGORY',
            CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
            'BKU' AS 'TRANSASKI'

            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId =outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            INNER JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId

            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20')
            AND cashout.szBranchId = '260'
            AND cashOut.szAccountId = '120000'
            AND cashoutItem.szAccountId = '130101'
            UNION ALL
            SELECT
            cashin.szBranchId AS 'ID_DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
            branch.szCompanyId AS 'ENTITAS',
            cashinItem.szDocId AS 'NO_DOK',
            DATE(cashIn.dtmDoc) AS 'TANGGAL',
            DAY(cashin.dtmDoc) AS 'HARI',
            MONTH(cashin.dtmDoc) AS 'BULAN',
            YEAR(cashin.dtmDoc) AS 'TAHUN',
            cashin.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA_SALES',
            cashin.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            cashinItem.szAccountId AS 'NO_AKUN2',
            account2.szName AS 'NAMA_AKUN2',
            'Penerimaan Petty Cash' AS 'CATEGORY',
            CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
            'BTU' AS 'TRANSAKSI'

            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            INNER JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId

            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20')
            AND cashin.szBranchId = '260'
            AND cashin.szAccountId = '120000'
            AND cashInItem.szAccountId = '130101'

            UNION ALL

            SELECT
            cashout.szBranchId AS 'ID_DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
            branch.szCompanyId AS 'ENTITAS',
            '' AS 'NO DOK',
            DATE(cashout.dtmDoc) AS 'TANGGAL',
            DAY(cashout.dtmDoc) AS 'HARI',
            MONTH(cashout.dtmDoc) AS 'BULAN',
            YEAR(cashout.dtmDoc) AS 'TAHUN',
            cashout.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA SALES',
            cashout.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            '' AS 'NO_AKUN2',
            '' AS 'NAMA_AKUN2',
            'Pengeluaran Biaya' AS 'CATEGORY',
            SUM(CAST(cashoutItem.decAmount AS DECIMAL))*-1 AS 'NILAI',
            'BKU3' AS 'TRANSASKI'

            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId AND cashout.szDocStatus = 'APPLIED'
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS outbalance ON cashoutItem.szDocId =outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            INNER JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20'
            AND cashout.szBranchId = '260'
            AND cashout.szAccountId IN ('120000')
            AND account2.szId NOT LIKE '130000'
            GROUP BY cashout.szBranchId, cashout.dtmDoc, cashout.szEmployeeId
            UNION ALL
            SELECT
            cashIn.szBranchId AS 'ID_DEPO',
            REPLACE(REPLACE(REPLACE(branch.szName,'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
            branch.szCompanyId AS 'ENTITAS',
            '' AS 'NO_DOK',
            DATE(cashIn.dtmDoc) AS 'TANGGAL',
            DAY(cashIn.dtmDoc) AS 'HARI',
            MONTH(cashIn.dtmDoc) AS 'BULAN',
            YEAR(cashIn.dtmDoc) AS 'TAHUN',
            cashIn.szEmployeeId AS 'ID_SALES',
            employee.szName AS 'NAMA_SALES',
            cashIn.szAccountId AS 'NO_AKUN1',
            account1.szName AS 'NAMA_AKUN1',
            '' AS 'NO_AKUN2',
            '' AS 'NAMA_AKUN2',
            'Pengeluaran Biaya' AS 'CATEGORY',
            SUM(CAST(cashInItem.decAmount AS DECIMAL)) AS 'NILAI',
            'BTU3' AS 'TRANSASKI'

            FROM dms_cas_doccashtempInitem AS cashInItem
            INNER JOIN dms_cas_doccashtempIn AS cashIn ON cashInItem.szDocId = cashIn.szDocId AND cashIn.szDocStatus = 'APPLIED'
            INNER JOIN dms_sm_branch AS branch ON cashIn.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashInItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashIn.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashIn.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS Inbalance ON cashInItem.szDocId =Inbalance.szDocId AND Inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashIn AS docCashIn ON Inbalance.szVoucherNo = docCashIn.szDocId

            WHERE cashIn.dtmDoc BETWEEN '2025-06-01' AND '2025-06-20'
            AND cashIn.szBranchId = '260'
            AND cashIn.szAccountId IN ('120000')
            AND account2.szId NOT LIKE '130101'
            GROUP BY cashIn.szBranchId, cashIn.dtmDoc, cashIn.szEmployeeId) AS DATA
            GROUP BY data.TANGGAL
            ORDER BY data.TANGGAL
            ");

            

        return view ('bod_2_kasir.index', compact('perusahaan','monitoring'));
    }
}
