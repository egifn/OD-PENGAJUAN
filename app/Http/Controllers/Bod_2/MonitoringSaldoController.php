<?php

namespace App\Http\Controllers\Bod_2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use Illuminate\Support\Facades\DB;

class MonitoringSaldoController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        $depo = '260';
        $tgl_dari = '1990-06-01';
        $sampai_dengan = '1990-06-30';

        $monitoring = DB::connection('mysql_ta')
            ->select("
            SELECT
            CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' 
            END AS 'SKU',
            SUM(
                CASE
                WHEN docDoItem.szTrnType IN ('SRE', 'RTR', 'SRT') THEN CAST(docDoItem.decQty * -1 / product1.dectobox AS DECIMAL(10,2))
                ELSE CAST(docDoItem.decQty / product1.dectobox AS DECIMAL(10,2))
                END
            ) AS 'TOTAL_QTY',
            SUM(CAST(price.decDiscPrinciple AS DECIMAL(10,2))) AS 'TOTAL_PIUTANG_PROMO_TIV',
            SUM(CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2))) AS 'TOTAL_BEFORE_PROMO',
            SUM(CAST(price.decAmount AS DECIMAL(10,2))) AS 'TOTAL_AFTER_PROMO'
            FROM dms_sd_docdo AS docDo
            INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
            INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
            INNER JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
            INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
            INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
            INNER JOIN dms_inv_product AS product2 
            ON (CASE 
                    WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                    THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                    ELSE docDoItem.szProductId 
                END) = product2.szId
            LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
            LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

            WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND docDo.szBranchId = '$depo'
            AND docDo.szDocStatus = 'APPLIED'
            AND product2.szName NOT LIKE '%TISSU%'
            AND docDo.szEmployeeId NOT LIKE '%-RNG'
           
            GROUP BY 
            CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' 
            END
                ");
        
           
        $segmen = DB::connection('mysql_ta')
            ->select("
                SELECT
            hierarchy.szDescription AS 'SEGMEN',
            SUM(
                CASE
                WHEN docDoItem.szTrnType IN ('SRE', 'RTR', 'SRT') THEN CAST(docDoItem.decQty * -1 / product1.dectobox AS DECIMAL(10,2))
                ELSE CAST(docDoItem.decQty / product1.dectobox AS DECIMAL(10,2))
                END
            ) AS 'TOTAL_QTY',
            
            SUM(CAST(price.decDiscPrinciple AS DECIMAL(10,2))) AS 'TOTAL_PIUTANG_PROMO_TIV',
            SUM(CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2))) AS 'TOTAL_BEFORE_PROMO',
            SUM(CAST(price.decAmount AS DECIMAL(10,2))) AS 'TOTAL_AFTER_PROMO'

            FROM dms_sd_docdo AS docDo

            INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
            INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
            INNER JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
            INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
            INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
            INNER JOIN dms_inv_product AS product2 
            ON (CASE 
                    WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                    THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                    ELSE docDoItem.szProductId 
                END) = product2.szId
            LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
            LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

            WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND docDo.szBranchId = '$depo'
            AND docDo.szDocStatus = 'APPLIED'
            AND product2.szName NOT LIKE '%TISSU%'
            AND docDo.szEmployeeId NOT LIKE '%-RNG'

            GROUP BY hierarchy.szDescription
            ORDER BY hierarchy.szDescription
        ");

        $tipe_sales = DB::connection('mysql_ta')
            ->select("
                SELECT
                CASE
                    WHEN docDo.bCash = '1' THEN 'TUNAI'
                    ELSE 'KREDIT'
                END AS 'TIPE_SALES',

                SUM(
                    CASE
                    WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 1
                    WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 1
                    ELSE 0
                    END
                ) AS 'TOTAL_SKU',

                SUM(CAST(price.decDiscPrinciple AS DECIMAL(10,2))) AS 'TOTAL_PIUTANG_PROMO_TIV',
                SUM(CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2))) AS 'TOTAL_BEFORE_PROMO',
                SUM(CAST(price.decAmount AS DECIMAL(10,2))) AS 'TOTAL_AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                        WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                        THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                        ELSE docDoItem.szProductId 
                    END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                    docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                    OR product2.szUomId IN ('BOX','PCS','PACK')
                )
                GROUP BY TIPE_SALES

            ");

        $salesman = DB::connection('mysql_ta')
            ->select("SELECT
                SUM(main.QTY) AS 'TOTAL_QTY',
                SUM(main.`PIUTANG PROMO TIV`) AS 'TOTAL_PIUTANG_PROMO_TIV',
                SUM(main.`BEFORE PROMO`) AS 'TOTAL_BEFORE_PROMO',
                SUM(main.`AFTER PROMO`) AS 'TOTAL_AFTER_PROMO'
                FROM (
                SELECT
                    IFNULL(employee.szName, '') AS SALESMAN,
                    
                    CASE
                    WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType IN ('SRE','RTR','RST') THEN CAST(docDoItem.decQty * -1 AS DECIMAL(10,2))
                    WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL(10,2))

                    WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType IN ('SRE','RTR','RST') THEN CAST(docDoItem.decQty * -1 AS DECIMAL(10,2))
                    WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL(10,2))

                    WHEN docDoItem.szTrnType IN ('SRE','RTR','SRT') THEN CAST(docDoItem.decQty * -1 / product1.dectobox AS DECIMAL(10,2))
                    ELSE IFNULL(CAST(docDoItem.decQty / product1.dectobox AS DECIMAL(10,2)), 0)
                    END AS QTY,

                    CAST(price.decDiscPrinciple AS DECIMAL(10,2)) AS `PIUTANG PROMO TIV`,
                    CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2)) AS `BEFORE PROMO`,
                    CAST(price.decAmount AS DECIMAL(10,2)) AS `AFTER PROMO`

                FROM dms_sd_docdo AS docDo
                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                    ON (CASE 
                        WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                        THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                        ELSE docDoItem.szProductId 
                        END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND docDo.szBranchId = '$depo'
                    AND docDo.szDocStatus = 'APPLIED'
                    AND product2.szName NOT LIKE '%TISSU%'
                    AND docDo.szEmployeeId NOT LIKE '%-RNG'
                    AND (
                    docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                    OR product2.szUomId IN ('BOX','PCS','PACK')
                    )
                ) AS main");

        $gudang_dist = DB::connection('mysql_ta')
            ->select("
            SELECT
            combined.TRANSAKSI,
            SUM(combined.QTY) AS 'TOTAL_QTY'
            FROM (
            -- BKB DISTRIBUSI
            SELECT
                'BKB DISTRIBUSI' AS TRANSAKSI,
		CAST(bkb.decQty / product.dectobox AS DECIMAL) * -1 AS QTY
            FROM dms_inv_docstockoutdistributionitem AS bkb
            INNER JOIN dms_inv_docstockoutdistribution AS bkb2 ON bkb.szDocId = bkb2.szDocId
            INNER JOIN dms_pi_employee AS employee ON bkb2.szEmployeeId = employee.szId
            INNER JOIN dms_sm_branch AS branch ON bkb2.szBranchId = branch.szId
            INNER JOIN dms_inv_product AS product ON bkb.szProductId = product.szId
            INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                    WHEN RIGHT(bkb.szProductId, 1) = 'P' 
                    THEN LEFT(bkb.szProductId, CHAR_LENGTH(bkb.szProductId) - 1)
                    ELSE bkb.szProductId 
                    END) = product2.szId
            WHERE bkb2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND bkb2.szBranchId = '=$depo'
                AND bkb2.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND bkb2.szEmployeeId NOT LIKE '%-RNG'

            UNION ALL

            -- BTB DISTRIBUSI
            SELECT
                'BTB DISTRIBUSI' AS TRANSAKSI,
                CAST(btb.decQty / product.dectobox AS DECIMAL) AS QTY
            FROM dms_inv_docstockindistributionitem AS btb
            INNER JOIN dms_inv_docstockindistribution AS btb2 ON btb.szDocId = btb2.szDocId
            INNER JOIN dms_pi_employee AS employee ON btb2.szEmployeeId = employee.szId
            INNER JOIN dms_sm_branch AS branch ON btb2.szBranchId = branch.szId
            INNER JOIN dms_inv_product AS product ON btb.szProductId = product.szId
            INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                    WHEN RIGHT(btb.szProductId, 1) = 'P' 
                    THEN LEFT(btb.szProductId, CHAR_LENGTH(btb.szProductId) - 1)
                    ELSE btb.szProductId 
                    END) = product2.szId
            WHERE btb2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND btb2.szBranchId = '$depo'
                AND btb2.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND btb2.szEmployeeId NOT LIKE '%-RNG'
            ) AS combined
            GROUP BY combined.TRANSAKSI
            ORDER BY combined.TRANSAKSI
                ");

        $gudang_supp = DB::connection('mysql_ta')
            ->select("
                SELECT 
            TRANSAKSI,
            SUM(QTY) AS TOTAL_QTY
            FROM (
            -- BTB SUPPLIER
            SELECT 
                'BTB SUPPLIER' AS TRANSAKSI,
                btbsupp1.decQty AS QTY
            FROM dms_inv_docstockinsupplieritem AS btbsupp1
            INNER JOIN dms_inv_docstockinsupplier AS btbsupp2 ON btbsupp1.szDocId = btbsupp2.szDocId
            INNER JOIN dms_inv_product AS product ON btbsupp1.szProductId = product.szId
            WHERE btbsupp2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND btbsupp2.szBranchId = '$depo'
                AND btbsupp2.szDocStatus = 'APPLIED'
                AND product.szName NOT LIKE '%TISSU%'

            UNION ALL

            -- BKB SUPPLIER
            SELECT 
                'BKB SUPPLIER' AS TRANSAKSI,
                CAST(bkbsupp1.decQty AS DECIMAL) * -1 AS QTY
            FROM dms_inv_docstockOutsupplieritem AS bkbsupp1
            INNER JOIN dms_inv_docstockOutsupplier AS bkbsupp2 ON bkbsupp1.szDocId = bkbsupp2.szDocId
            INNER JOIN dms_inv_product AS product ON bkbsupp1.szProductId = product.szId
            WHERE bkbsupp2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND bkbsupp2.szBranchId = '$depo'
                AND bkbsupp2.szDocStatus = 'APPLIED'
                AND product.szName NOT LIKE '%TISSU%'
            ) AS combined_data
            GROUP BY TRANSAKSI
                ");
            
        $kasir = DB::connection('mysql_ta')
            ->select("SELECT 
            CATEGORY,
            SUM(NILAI) AS TOTAL_NILAI
        FROM (
            -- BKU Penjualan Tunai/Tagihan
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashoutItem.szDocId AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashoutItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                CASE
                    WHEN account2.szName = 'HPT' AND cashOut.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName IN ('HPT KOPO','HPT LODAYA') AND cashOut.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName = 'HPT' AND cashOut.szAccountId = '140000' THEN 'Penjualan Tunai Transfer'
                    WHEN account2.szName = 'HTT' AND cashOut.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'SPT' AND cashOut.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashOut.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Tunai'
                    WHEN account2.szName = 'HTC' AND cashOut.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'BIAYA TRANSFER' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA ADMIN BANK' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA MATERAI' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'SPT' AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName = 'KAS KE KAS' AND cashOut.szAccountId = '110000' THEN 'Pengeluaran Petty Cash'
                    ELSE 'Other' 
                END AS 'CATEGORY',
                CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            LEFT JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            LEFT JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashout.szBranchId = '$depo'
            AND cashout.szAccountId IN ('110000','140000')
            AND cashoutItem.szDescription NOT LIKE '%/spt/31052025%'

            UNION ALL

            -- BTU Penjualan Tunai/Tagihan
            SELECT
                cashin.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashinItem.szDocId AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashin.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashin.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashinItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                CASE
                    WHEN account2.szName = 'HPT' AND cashIn.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName IN ('HPT KOPO','HPT LODAYA') AND cashIn.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName = 'HPT' AND cashIn.szAccountId = '140000' THEN 'Penjualan Tunai Transfer'
                    WHEN account2.szName = 'HTT' AND cashIn.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'SPT' AND cashIn.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashIn.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Tunai'
                    WHEN account2.szName = 'HTC' AND cashIn.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'BIAYA TRANSFER' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA ADMIN BANK' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA MATERAI' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'SPT' AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName = 'KAS KE KAS' AND cashIn.szAccountId = '110000' THEN 'Pengeluaran Petty Cash'
                    ELSE 'Other' 
                END AS 'CATEGORY',
                CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
                'BTU' AS 'TRANSAKSI'
            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            LEFT JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashin.szBranchId = '$depo'
            AND cashIn.szAccountId IN ('110000','140000')
            AND cashInItem.szDescription NOT LIKE '%/spt/31052025%'

            UNION ALL

            -- BKU Setoran Tagihan Non Tunai
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashoutItem.szDocId AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashoutItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Setoran Tagihan Non Tunai' AS 'CATEGORY',
                CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            LEFT JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            LEFT JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashout.szBranchId = '$depo'
            AND cashoutItem.szAccountId = '140103'
            AND cashOut.szAccountId NOT LIKE '110000'

            UNION ALL

            -- BTU Setoran Tagihan Non Tunai
            SELECT
                cashin.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashinItem.szDocId AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashin.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashin.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashinItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Setoran Tagihan Non Tunai' AS 'CATEGORY',
                CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
                'BTU' AS 'TRANSAKSI'
            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            LEFT JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashin.szBranchId = '$depo'
            AND cashInItem.szAccountId = '140103'
            AND cashin.szAccountId NOT LIKE '110000'

            UNION ALL

            -- CLEARING Tagihan Non Tunai
            SELECT
                clearing.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA ','DEPO '),'LP ','DEPO '),'WPS ','DEPO ') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                '' AS 'NO DOK',
                DATE(clearing.dtmDoc) AS 'TANGGAL',
                bg.szEmployeeId AS 'ID SALESMAN',
                employee.szName AS 'NAMA SALESMAN',
                '' AS 'NO AKUN1',
                '' AS 'NAMA AKUN1',
                '' AS 'NO AKUN2',
                '' AS 'NAMA AKUN2',
                'Tagihan Non Tunai' AS 'CATEGORY',
                bg.decAmount AS 'NILAI',
                'CLEARING' AS 'TRANSAKSI'
            FROM dms_cas_docbgclearing AS clearing
            INNER JOIN dms_sm_branch AS branch ON clearing.szBranchId = branch.szId
            INNER JOIN dms_cas_docBgClearingItem AS clearingItem ON clearing.szDocId = clearingItem.szDocId
            INNER JOIN dms_cas_bg AS bg ON clearingItem.szRefDocId = bg.szId
            INNER JOIN dms_pi_employee AS employee ON bg.szEmployeeId = employee.szId
            WHERE clearing.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND clearing.szBranchId = '$depo'
            UNION ALL

            -- BKU Penerimaan Petty Cash
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashoutItem.szDocId AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashoutItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Penerimaan Petty Cash' AS 'CATEGORY',
                CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            LEFT JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            LEFT JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashout.szBranchId = '$depo'
            AND cashOut.szAccountId = '120000'
            AND cashoutItem.szAccountId = '130101'

            UNION ALL

            -- BTU Penerimaan Petty Cash
            SELECT
                cashin.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashinItem.szDocId AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashin.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashin.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashinItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Penerimaan Petty Cash' AS 'CATEGORY',
                CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
                'BTU' AS 'TRANSAKSI'
            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            LEFT JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashin.szBranchId = '$depo'
            AND cashin.szAccountId = '120000'
            AND cashInItem.szAccountId = '130101'

            UNION ALL

            -- BKU Pengeluaran Biaya
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                '' AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                '' AS 'NO AKUN2',
                '' AS 'NAMA AKUN2',
                'Pengeluaran Biaya' AS 'CATEGORY',
                SUM(CAST(cashoutItem.decAmount AS DECIMAL))*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId AND cashout.szDocStatus = 'APPLIED'
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS outbalance ON cashoutItem.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            INNER JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND cashout.szAccountId IN ('120000')
            AND cashout.szBranchId = '$depo'
            AND account2.szId NOT LIKE '130000'
            GROUP BY cashout.szBranchId, cashout.dtmDoc, cashout.szEmployeeId, branch.szName, branch.szCompanyId, employee.szName, cashout.szAccountId, account1.szName

            UNION ALL

            -- BTU Pengeluaran Biaya
            SELECT
                cashIn.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                '' AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashIn.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashIn.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                '' AS 'NO AKUN2',
                '' AS 'NAMA AKUN2',
                'Pengeluaran Biaya' AS 'CATEGORY',
                SUM(CAST(cashInItem.decAmount AS DECIMAL)) AS 'NILAI',
                'BTU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempInitem AS cashInItem
            INNER JOIN dms_cas_doccashtempIn AS cashIn ON cashInItem.szDocId = cashIn.szDocId AND cashIn.szDocStatus = 'APPLIED'
            INNER JOIN dms_sm_branch AS branch ON cashIn.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashInItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashIn.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashIn.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS Inbalance ON cashInItem.szDocId = Inbalance.szDocId AND Inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashIn AS docCashIn ON Inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashIn.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND cashIn.szAccountId IN ('120000')
            AND cashIn.szBranchId = '$depo'
            AND account2.szId NOT LIKE '130101'
            GROUP BY cashIn.szBranchId, cashIn.dtmDoc, cashIn.szEmployeeId, branch.szName, branch.szCompanyId, employee.szName, cashIn.szAccountId, account1.szName
        ) AS CombinedData
        GROUP BY CATEGORY
        ORDER BY CATEGORY");


        foreach ($kasir as $item) {
            $dataKasir[$item->CATEGORY] = $item->TOTAL_NILAI;
        }

        // dd($dataKasir);


    $pelunasan = DB::connection('mysql_ta')
            ->select("
            SELECT 
                hasil.TRANSAKSI,
                SUM(hasil.`NILAI PAYMENT`) AS TOTAL_NILAI_PAYMENT
            FROM (
                -- PELUNASAN TUNAI
                SELECT
                    'Pelunasan Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                WHERE payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType = 'TUNAI'
                    AND payment.szDocStatus = 'APPLIED'
                    AND payment.szBranchId = '$depo'
                    AND payment.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId

                UNION 

                -- PELUNASAN NON TUNAI
                SELECT
                    'Pelunasan Non Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                INNER JOIN dms_cas_bg AS bg 
                    ON paymentItemDetail.szRefId = bg.szId 
                    AND bg.szStatus = 'CLEARING'
                WHERE bg.dtmClearing BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType NOT LIKE 'TUNAI'
                    AND payment.szBranchId = '$depo'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId
            ) AS hasil
            GROUP BY hasil.TRANSAKSI

            UNION ALL

            -- TOTAL KESELURUHAN
            SELECT 
                'TOTAL KESELURUHAN' AS TRANSAKSI,
                SUM(hasil.`NILAI PAYMENT`) AS TOTAL_NILAI_PAYMENT
            FROM (
                -- Salinan subquery dari atas
                SELECT
                    'Pelunasan Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                WHERE payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType = 'TUNAI'
                    AND payment.szDocStatus = 'APPLIED'
                    AND payment.szBranchId = '$depo'
                    AND payment.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId

                UNION ALL

                SELECT
                    'Pelunasan Non Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                INNER JOIN dms_cas_bg AS bg 
                    ON paymentItemDetail.szRefId = bg.szId 
                    AND bg.szStatus = 'CLEARING'
                WHERE bg.dtmClearing BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType NOT LIKE 'TUNAI'
                    AND payment.szBranchId = '$depo'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId
            ) AS hasil
            ");

            $invoice = DB::connection('mysql_ta')
            ->select("
            SELECT 
                kategori,
                SUM(`SALES AFTER PROMO`) AS total_sales_after_promo
            FROM (
                SELECT DISTINCT
                    invoice.szDocId AS 'NO INVOICE',
                    CAST(SUM(invoiceItemPrice.decAmount) AS DECIMAL) AS 'SALES AFTER PROMO',
                    'INVOICE BARU' AS kategori

                FROM dms_sd_docinvoice AS invoice

                INNER JOIN dms_sm_branch AS branch ON invoice.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON invoice.szCustomerId = customer.szId
                INNER JOIN dms_ar_customerHierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId
                LEFT JOIN dms_sd_docdoinvoice AS doInvoice ON invoice.szDocId = doInvoice.szDocInvoiceId
                LEFT JOIN dms_sd_docinvoiceitem AS InvoiceItem ON invoice.szDocId = invoiceItem.szDocId
                LEFT JOIN dms_sd_docDo AS docdo ON InvoiceItem.szDocDoId = docDo.szDocId
                LEFT JOIN dms_sd_docinvoiceitemprice AS invoiceItemPrice ON invoice.szDocId = invoiceItemPrice.szDocId AND invoiceItemPrice.intItemNumber = InvoiceItem.intItemNumber
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId

                WHERE invoice.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND invoice.bCash = '0'
                    AND invoice.szDocStatus = 'APPLIED'
                    AND invoice.szBranchId = '$depo'
                    AND (
                        InvoiceItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                        OR InvoiceItem.szUomId IN ('BOX','PCS','PACK')
                    )

                GROUP BY invoice.szDocId
            ) AS subquery
            GROUP BY kategori
            ");
//  dd($gudang_dist);

        return view ('bod_2.index',
        [
            'perusahaan' => $perusahaan,
            'monitoring' => $monitoring,
            'segmen' => $segmen,
            'tipe_sales' => $tipe_sales,
            'salesman' => $salesman,
            'gudang_dist' => $gudang_dist,
            'gudang_supp' => $gudang_supp,
            
            'pelunasan' => $pelunasan,
            'invoice' => $invoice,
            'kasir' => $dataKasir ?? []
            
        ]);
    }

    public function cari(Request $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');
    
        $perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
        
        $monitoring = $connection_db
            ->select("
                
            SELECT
            CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' 
            END AS 'SKU',
            SUM(
                CASE
                WHEN docDoItem.szTrnType IN ('SRE', 'RTR', 'SRT') THEN CAST(docDoItem.decQty * -1 / product1.dectobox AS DECIMAL(10,2))
                ELSE CAST(docDoItem.decQty / product1.dectobox AS DECIMAL(10,2))
                END
            ) AS 'TOTAL_QTY',
            SUM(CAST(price.decDiscPrinciple AS DECIMAL(10,2))) AS 'TOTAL_PIUTANG_PROMO_TIV',
            SUM(CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2))) AS 'TOTAL_BEFORE_PROMO',
            SUM(CAST(price.decAmount AS DECIMAL(10,2))) AS 'TOTAL_AFTER_PROMO'
            FROM dms_sd_docdo AS docDo
            INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
            INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
            INNER JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
            INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
            INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
            INNER JOIN dms_inv_product AS product2 
            ON (CASE 
                    WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                    THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                    ELSE docDoItem.szProductId 
                END) = product2.szId
            LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
            LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

            WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND docDo.szBranchId = '$depo'
            AND docDo.szDocStatus = 'APPLIED'
            AND product2.szName NOT LIKE '%TISSU%'
            AND docDo.szEmployeeId NOT LIKE '%-RNG'
           
            GROUP BY 
            CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' 
            END
                
            "); 
            

        $segmen = $connection_db
            ->select("
                SELECT
            hierarchy.szDescription AS 'SEGMEN',
            SUM(
                CASE
                WHEN docDoItem.szTrnType IN ('SRE', 'RTR', 'SRT') THEN CAST(docDoItem.decQty * -1 / product1.dectobox AS DECIMAL(10,2))
                ELSE CAST(docDoItem.decQty / product1.dectobox AS DECIMAL(10,2))
                END
            ) AS 'TOTAL_QTY',
            
            SUM(CAST(price.decDiscPrinciple AS DECIMAL(10,2))) AS 'TOTAL_PIUTANG_PROMO_TIV',
            SUM(CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2))) AS 'TOTAL_BEFORE_PROMO',
            SUM(CAST(price.decAmount AS DECIMAL(10,2))) AS 'TOTAL_AFTER_PROMO'

            FROM dms_sd_docdo AS docDo

            INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
            INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
            INNER JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
            INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
            INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
            INNER JOIN dms_inv_product AS product2 
            ON (CASE 
                    WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                    THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                    ELSE docDoItem.szProductId 
                END) = product2.szId
            LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
            LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

            WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND docDo.szBranchId = '$depo'
            AND docDo.szDocStatus = 'APPLIED'
            AND product2.szName NOT LIKE '%TISSU%'
            AND docDo.szEmployeeId NOT LIKE '%-RNG'

            GROUP BY hierarchy.szDescription
            ORDER BY hierarchy.szDescription
        ");

        $tipe_sales = $connection_db
            ->select("
                SELECT
                CASE
                    WHEN docDo.bCash = '1' THEN 'TUNAI'
                    ELSE 'KREDIT'
                END AS 'TIPE_SALES',

                SUM(
                    CASE
                    WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 1
                    WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 1
                    ELSE 0
                    END
                ) AS 'TOTAL_SKU',

                SUM(CAST(price.decDiscPrinciple AS DECIMAL(10,2))) AS 'TOTAL_PIUTANG_PROMO_TIV',
                SUM(CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2))) AS 'TOTAL_BEFORE_PROMO',
                SUM(CAST(price.decAmount AS DECIMAL(10,2))) AS 'TOTAL_AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                        WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                        THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                        ELSE docDoItem.szProductId 
                    END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                    docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                    OR product2.szUomId IN ('BOX','PCS','PACK')
                )
                GROUP BY TIPE_SALES

            ");

        $salesman = $connection_db
            ->select("SELECT
                SUM(main.QTY) AS 'TOTAL_QTY',
                SUM(main.`PIUTANG PROMO TIV`) AS 'TOTAL_PIUTANG_PROMO_TIV',
                SUM(main.`BEFORE PROMO`) AS 'TOTAL_BEFORE_PROMO',
                SUM(main.`AFTER PROMO`) AS 'TOTAL_AFTER_PROMO'
                FROM (
                SELECT
                    IFNULL(employee.szName, '') AS SALESMAN,
                    
                    CASE
                    WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType IN ('SRE','RTR','RST') THEN CAST(docDoItem.decQty * -1 AS DECIMAL(10,2))
                    WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL(10,2))

                    WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType IN ('SRE','RTR','RST') THEN CAST(docDoItem.decQty * -1 AS DECIMAL(10,2))
                    WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL(10,2))

                    WHEN docDoItem.szTrnType IN ('SRE','RTR','SRT') THEN CAST(docDoItem.decQty * -1 / product1.dectobox AS DECIMAL(10,2))
                    ELSE IFNULL(CAST(docDoItem.decQty / product1.dectobox AS DECIMAL(10,2)), 0)
                    END AS QTY,

                    CAST(price.decDiscPrinciple AS DECIMAL(10,2)) AS `PIUTANG PROMO TIV`,
                    CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL(10,2)) AS `BEFORE PROMO`,
                    CAST(price.decAmount AS DECIMAL(10,2)) AS `AFTER PROMO`

                FROM dms_sd_docdo AS docDo
                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                    ON (CASE 
                        WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                        THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                        ELSE docDoItem.szProductId 
                        END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND docDo.szBranchId = '$depo'
                    AND docDo.szDocStatus = 'APPLIED'
                    AND product2.szName NOT LIKE '%TISSU%'
                    AND docDo.szEmployeeId NOT LIKE '%-RNG'
                    AND (
                    docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                    OR product2.szUomId IN ('BOX','PCS','PACK')
                    )
                ) AS main");

        $gudang_dist = $connection_db
            ->select("
            SELECT
            combined.TRANSAKSI,
            SUM(combined.QTY) AS 'TOTAL_QTY'
            FROM (
            -- BKB DISTRIBUSI
            SELECT
                'BKB DISTRIBUSI' AS TRANSAKSI,
		CAST(bkb.decQty / product.dectobox AS DECIMAL) * -1 AS QTY
            FROM dms_inv_docstockoutdistributionitem AS bkb
            INNER JOIN dms_inv_docstockoutdistribution AS bkb2 ON bkb.szDocId = bkb2.szDocId
            INNER JOIN dms_pi_employee AS employee ON bkb2.szEmployeeId = employee.szId
            INNER JOIN dms_sm_branch AS branch ON bkb2.szBranchId = branch.szId
            INNER JOIN dms_inv_product AS product ON bkb.szProductId = product.szId
            INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                    WHEN RIGHT(bkb.szProductId, 1) = 'P' 
                    THEN LEFT(bkb.szProductId, CHAR_LENGTH(bkb.szProductId) - 1)
                    ELSE bkb.szProductId 
                    END) = product2.szId
            WHERE bkb2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND bkb2.szBranchId = '$depo'
                AND bkb2.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND bkb2.szEmployeeId NOT LIKE '%-RNG'

            UNION ALL

            -- BTB DISTRIBUSI
            SELECT
                'BTB DISTRIBUSI' AS TRANSAKSI,
                CAST(btb.decQty / product.dectobox AS DECIMAL) AS QTY
            FROM dms_inv_docstockindistributionitem AS btb
            INNER JOIN dms_inv_docstockindistribution AS btb2 ON btb.szDocId = btb2.szDocId
            INNER JOIN dms_pi_employee AS employee ON btb2.szEmployeeId = employee.szId
            INNER JOIN dms_sm_branch AS branch ON btb2.szBranchId = branch.szId
            INNER JOIN dms_inv_product AS product ON btb.szProductId = product.szId
            INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                    WHEN RIGHT(btb.szProductId, 1) = 'P' 
                    THEN LEFT(btb.szProductId, CHAR_LENGTH(btb.szProductId) - 1)
                    ELSE btb.szProductId 
                    END) = product2.szId
            WHERE btb2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND btb2.szBranchId = '$depo'
                AND btb2.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND btb2.szEmployeeId NOT LIKE '%-RNG'
            ) AS combined
            GROUP BY combined.TRANSAKSI
            ORDER BY combined.TRANSAKSI
                ");

        $gudang_supp = $connection_db
            ->select("
            
                SELECT 
            TRANSAKSI,
            SUM(QTY) AS TOTAL_QTY
            FROM (
            -- BTB SUPPLIER
            SELECT 
                'BTB SUPPLIER' AS TRANSAKSI,
                btbsupp1.decQty AS QTY
            FROM dms_inv_docstockinsupplieritem AS btbsupp1
            INNER JOIN dms_inv_docstockinsupplier AS btbsupp2 ON btbsupp1.szDocId = btbsupp2.szDocId
            INNER JOIN dms_inv_product AS product ON btbsupp1.szProductId = product.szId
            WHERE btbsupp2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND btbsupp2.szBranchId = '$depo'
                AND btbsupp2.szDocStatus = 'APPLIED'
                AND product.szName NOT LIKE '%TISSU%'

            UNION ALL

            -- BKB SUPPLIER
            SELECT 
                'BKB SUPPLIER' AS TRANSAKSI,
                CAST(bkbsupp1.decQty AS DECIMAL) * -1 AS QTY
            FROM dms_inv_docstockOutsupplieritem AS bkbsupp1
            INNER JOIN dms_inv_docstockOutsupplier AS bkbsupp2 ON bkbsupp1.szDocId = bkbsupp2.szDocId
            INNER JOIN dms_inv_product AS product ON bkbsupp1.szProductId = product.szId
            WHERE bkbsupp2.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND bkbsupp2.szBranchId = '$depo'
                AND bkbsupp2.szDocStatus = 'APPLIED'
                AND product.szName NOT LIKE '%TISSU%'
            ) AS combined_data
            GROUP BY TRANSAKSI
                ");
            
        $kasir = $connection_db
            ->select("SELECT 
            CATEGORY,
            SUM(NILAI) AS TOTAL_NILAI
        FROM (
            -- BKU Penjualan Tunai/Tagihan
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashoutItem.szDocId AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashoutItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                CASE
                    WHEN account2.szName = 'HPT' AND cashOut.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName IN ('HPT KOPO','HPT LODAYA') AND cashOut.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName = 'HPT' AND cashOut.szAccountId = '140000' THEN 'Penjualan Tunai Transfer'
                    WHEN account2.szName = 'HTT' AND cashOut.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'SPT' AND cashOut.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashOut.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Tunai'
                    WHEN account2.szName = 'HTC' AND cashOut.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'BIAYA TRANSFER' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA ADMIN BANK' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA MATERAI' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashOut.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'SPT' AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashOut.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName = 'KAS KE KAS' AND cashOut.szAccountId = '110000' THEN 'Pengeluaran Petty Cash'
                    ELSE 'Other' 
                END AS 'CATEGORY',
                CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            LEFT JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            LEFT JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashout.szBranchId = '$depo'
            AND cashout.szAccountId IN ('110000','140000')
            AND cashoutItem.szDescription NOT LIKE '%/spt/31052025%'

            UNION ALL

            -- BTU Penjualan Tunai/Tagihan
            SELECT
                cashin.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashinItem.szDocId AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashin.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashin.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashinItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                CASE
                    WHEN account2.szName = 'HPT' AND cashIn.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName IN ('HPT KOPO','HPT LODAYA') AND cashIn.szAccountId = '110000' THEN 'Penjualan Tunai'
                    WHEN account2.szName = 'HPT' AND cashIn.szAccountId = '140000' THEN 'Penjualan Tunai Transfer'
                    WHEN account2.szName = 'HTT' AND cashIn.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'SPT' AND cashIn.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashIn.szAccountId = '110000' THEN 'Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Tunai'
                    WHEN account2.szName = 'HTC' AND cashIn.szAccountId = '110000' THEN 'Tagihan Tunai'
                    WHEN account2.szName = 'BIAYA TRANSFER' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA ADMIN BANK' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'BIAYA MATERAI' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashIn.szAccountId = '110000' THEN 'Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'STC' AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Non Tunai'
                    WHEN account2.szName = 'SPT' AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Penjualan Tunai'
                    WHEN account2.szName = 'STT' AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName IN ('SPT KOPO','SPT LODAYA') AND cashIn.szAccountId = '140000' THEN 'Penerimaan Setoran Tagihan Tunai'
                    WHEN account2.szName = 'KAS KE KAS' AND cashIn.szAccountId = '110000' THEN 'Pengeluaran Petty Cash'
                    ELSE 'Other' 
                END AS 'CATEGORY',
                CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
                'BTU' AS 'TRANSAKSI'
            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            LEFT JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashin.szBranchId = '$depo'
            AND cashIn.szAccountId IN ('110000','140000')
            AND cashInItem.szDescription NOT LIKE '%/spt/31052025%'

            UNION ALL

            -- BKU Setoran Tagihan Non Tunai
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashoutItem.szDocId AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashoutItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Setoran Tagihan Non Tunai' AS 'CATEGORY',
                CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            LEFT JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            LEFT JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashout.szBranchId = '$depo'
            AND cashoutItem.szAccountId = '140103'
            AND cashOut.szAccountId NOT LIKE '110000'

            UNION ALL

            -- BTU Setoran Tagihan Non Tunai
            SELECT
                cashin.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashinItem.szDocId AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashin.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashin.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashinItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Setoran Tagihan Non Tunai' AS 'CATEGORY',
                CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
                'BTU' AS 'TRANSAKSI'
            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            LEFT JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashin.szBranchId = '$depo'
            AND cashInItem.szAccountId = '140103'
            AND cashin.szAccountId NOT LIKE '110000'

            UNION ALL

            -- CLEARING Tagihan Non Tunai
            SELECT
                clearing.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA ','DEPO '),'LP ','DEPO '),'WPS ','DEPO ') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                '' AS 'NO DOK',
                DATE(clearing.dtmDoc) AS 'TANGGAL',
                bg.szEmployeeId AS 'ID SALESMAN',
                employee.szName AS 'NAMA SALESMAN',
                '' AS 'NO AKUN1',
                '' AS 'NAMA AKUN1',
                '' AS 'NO AKUN2',
                '' AS 'NAMA AKUN2',
                'Tagihan Non Tunai' AS 'CATEGORY',
                bg.decAmount AS 'NILAI',
                'CLEARING' AS 'TRANSAKSI'
            FROM dms_cas_docbgclearing AS clearing
            INNER JOIN dms_sm_branch AS branch ON clearing.szBranchId = branch.szId
            INNER JOIN dms_cas_docBgClearingItem AS clearingItem ON clearing.szDocId = clearingItem.szDocId
            INNER JOIN dms_cas_bg AS bg ON clearingItem.szRefDocId = bg.szId
            INNER JOIN dms_pi_employee AS employee ON bg.szEmployeeId = employee.szId
            WHERE clearing.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND clearing.szBranchId = '$depo'
            UNION ALL

            -- BKU Penerimaan Petty Cash
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashoutItem.szDocId AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashoutItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Penerimaan Petty Cash' AS 'CATEGORY',
                CAST(cashoutItem.decAmount AS DECIMAL)*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            LEFT JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS outbalance ON cashout.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            LEFT JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.szDocStatus = 'APPLIED'
            AND (cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashout.szBranchId = '$depo'
            AND cashOut.szAccountId = '120000'
            AND cashoutItem.szAccountId = '130101'

            UNION ALL

            -- BTU Penerimaan Petty Cash
            SELECT
                cashin.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                cashinItem.szDocId AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashin.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashin.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                cashinItem.szAccountId AS 'NO AKUN2',
                account2.szName AS 'NAMA AKUN2',
                'Penerimaan Petty Cash' AS 'CATEGORY',
                CAST(cashInItem.decAmount AS DECIMAL) AS 'NILAI',
                'BTU' AS 'TRANSAKSI'
            FROM dms_cas_doccashtempinitem AS cashinItem
            INNER JOIN dms_cas_doccashtempin AS cashin ON cashinItem.szDocId = cashin.szDocId
            INNER JOIN dms_sm_branch AS branch ON cashin.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account1 ON cashin.szAccountId = account1.szId
            INNER JOIN dms_fin_account AS account2 ON cashinItem.szAccountId = account2.szId
            LEFT JOIN dms_pi_employee AS employee ON cashin.szEmployeeid = employee.szId
            LEFT JOIN dms_cas_cashtempbalance AS inbalance ON cashin.szDocId = inbalance.szDocId AND inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashin AS docCashIn ON inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashin.szDocStatus = 'APPLIED'
            AND (cashin.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan')
            AND cashin.szBranchId = '$depo'
            AND cashin.szAccountId = '120000'
            AND cashInItem.szAccountId = '130101'

            UNION ALL

            -- BKU Pengeluaran Biaya
            SELECT
                cashout.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                '' AS 'NO DOK',
                DATE(cashout.dtmDoc) AS 'TANGGAL',
                cashout.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashout.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                '' AS 'NO AKUN2',
                '' AS 'NAMA AKUN2',
                'Pengeluaran Biaya' AS 'CATEGORY',
                SUM(CAST(cashoutItem.decAmount AS DECIMAL))*-1 AS 'NILAI',
                'BKU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempoutitem AS cashoutItem
            INNER JOIN dms_cas_doccashtempout AS cashout ON cashoutItem.szDocId = cashout.szDocId AND cashout.szDocStatus = 'APPLIED'
            INNER JOIN dms_sm_branch AS branch ON cashout.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashoutItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashout.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashout.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS outbalance ON cashoutItem.szDocId = outbalance.szDocId AND outbalance.szObjectId = 'DMSDocCashTempout' AND cashoutItem.intItemNumber = outbalance.intItemNumber
            INNER JOIN dms_cas_doccashout AS docCashout ON outbalance.szVoucherNo = docCashout.szDocId
            WHERE cashout.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND cashout.szAccountId IN ('120000')
            AND cashout.szBranchId = '$depo'
            AND account2.szId NOT LIKE '130000'
            GROUP BY cashout.szBranchId, cashout.dtmDoc, cashout.szEmployeeId, branch.szName, branch.szCompanyId, employee.szName, cashout.szAccountId, account1.szName

            UNION ALL

            -- BTU Pengeluaran Biaya
            SELECT
                cashIn.szBranchId AS 'ID DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                branch.szCompanyId AS 'ENTITAS',
                '' AS 'NO DOK',
                DATE(cashIn.dtmDoc) AS 'TANGGAL',
                cashIn.szEmployeeId AS 'ID SALES',
                employee.szName AS 'NAMA SALES',
                cashIn.szAccountId AS 'NO AKUN1',
                account1.szName AS 'NAMA AKUN1',
                '' AS 'NO AKUN2',
                '' AS 'NAMA AKUN2',
                'Pengeluaran Biaya' AS 'CATEGORY',
                SUM(CAST(cashInItem.decAmount AS DECIMAL)) AS 'NILAI',
                'BTU' AS 'TRANSASKI'
            FROM dms_cas_doccashtempInitem AS cashInItem
            INNER JOIN dms_cas_doccashtempIn AS cashIn ON cashInItem.szDocId = cashIn.szDocId AND cashIn.szDocStatus = 'APPLIED'
            INNER JOIN dms_sm_branch AS branch ON cashIn.szBranchId = branch.szId
            INNER JOIN dms_fin_account AS account2 ON cashInItem.szAccountId = account2.szId
            INNER JOIN dms_fin_account AS account1 ON cashIn.szAccountId = account1.szId
            INNER JOIN dms_pi_employee AS employee ON cashIn.szEmployeeid = employee.szId
            INNER JOIN dms_cas_cashtempbalance AS Inbalance ON cashInItem.szDocId = Inbalance.szDocId AND Inbalance.szObjectId = 'DMSDocCashTempIn' AND cashInItem.intItemNumber = Inbalance.intItemNumber
            INNER JOIN dms_cas_doccashIn AS docCashIn ON Inbalance.szVoucherNo = docCashIn.szDocId
            WHERE cashIn.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
            AND cashIn.szAccountId IN ('120000')
            AND cashIn.szBranchId = '$depo'
            AND account2.szId NOT LIKE '130101'
            GROUP BY cashIn.szBranchId, cashIn.dtmDoc, cashIn.szEmployeeId, branch.szName, branch.szCompanyId, employee.szName, cashIn.szAccountId, account1.szName
        ) AS CombinedData
        GROUP BY CATEGORY
        ORDER BY CATEGORY;");

        foreach ($kasir as $item) {
            $dataKasir[$item->CATEGORY] = $item->TOTAL_NILAI;
        }

    $pelunasan = $connection_db
            ->select("
            SELECT 
                hasil.TRANSAKSI,
                SUM(hasil.`NILAI PAYMENT`) AS TOTAL_NILAI_PAYMENT
            FROM (
                -- PELUNASAN TUNAI
                SELECT
                    'Pelunasan Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                WHERE payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType = 'TUNAI'
                    AND payment.szDocStatus = 'APPLIED'
                    AND payment.szBranchId = '$depo'
                    AND payment.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId

                UNION 

                -- PELUNASAN NON TUNAI
                SELECT
                    'Pelunasan Non Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                INNER JOIN dms_cas_bg AS bg 
                    ON paymentItemDetail.szRefId = bg.szId 
                    AND bg.szStatus = 'CLEARING'
                WHERE bg.dtmClearing BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType NOT LIKE 'TUNAI'
                    AND payment.szBranchId = '$depo'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId
            ) AS hasil
            GROUP BY hasil.TRANSAKSI

            UNION ALL

            -- TOTAL KESELURUHAN
            SELECT 
                'TOTAL KESELURUHAN' AS TRANSAKSI,
                SUM(hasil.`NILAI PAYMENT`) AS TOTAL_NILAI_PAYMENT
            FROM (
                -- Salinan subquery dari atas
                SELECT
                    'Pelunasan Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                WHERE payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType = 'TUNAI'
                    AND payment.szDocStatus = 'APPLIED'
                    AND payment.szBranchId = '$depo'
                    AND payment.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId

                UNION ALL

                SELECT
                    'Pelunasan Non Tunai' AS TRANSAKSI,
                    CAST(SUM(paymentItemDetail.decPayment) AS DECIMAL) AS `NILAI PAYMENT`
                FROM dms_ar_docpayment AS payment
                INNER JOIN dms_sm_branch AS branch ON payment.szBranchId = branch.szId
                INNER JOIN dms_pi_employee AS employee ON payment.szEmployeeId = employee.szId
                INNER JOIN dms_ar_docpaymentitem AS paymentItem ON payment.szDocId = paymentItem.szDocId
                INNER JOIN dms_ar_customer AS customer ON paymentItem.szCustomerId = customer.szId
                INNER JOIN dms_ar_docpaymentitemdetail AS paymentItemDetail 
                    ON paymentItem.szDocId = paymentItemDetail.szDocId 
                    AND paymentItemDetail.intItemNumber = paymentItem.intItemNumber
                INNER JOIN dms_ar_arinvoice AS arInvoice ON paymentItem.szInvoiceId = arInvoice.szDocId
                INNER JOIN dms_cas_bg AS bg 
                    ON paymentItemDetail.szRefId = bg.szId 
                    AND bg.szStatus = 'CLEARING'
                WHERE bg.dtmClearing BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND payment.bCash = '0'
                    AND paymentItemDetail.szPaymentType NOT LIKE 'TUNAI'
                    AND payment.szBranchId = '$depo'
                GROUP BY payment.szBranchId, payment.dtmDoc, payment.szEmployeeId, paymentItem.szInvoiceId
            ) AS hasil
            ");

        $invoice = $connection_db
            ->select("
            SELECT 
                kategori,
                SUM(`SALES AFTER PROMO`) AS total_sales_after_promo
            FROM (
                SELECT DISTINCT
                    invoice.szDocId AS 'NO INVOICE',
                    CAST(SUM(invoiceItemPrice.decAmount) AS DECIMAL) AS 'SALES AFTER PROMO',
                    'INVOICE BARU' AS kategori

                FROM dms_sd_docinvoice AS invoice

                INNER JOIN dms_sm_branch AS branch ON invoice.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON invoice.szCustomerId = customer.szId
                INNER JOIN dms_ar_customerHierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId
                LEFT JOIN dms_sd_docdoinvoice AS doInvoice ON invoice.szDocId = doInvoice.szDocInvoiceId
                LEFT JOIN dms_sd_docinvoiceitem AS InvoiceItem ON invoice.szDocId = invoiceItem.szDocId
                LEFT JOIN dms_sd_docDo AS docdo ON InvoiceItem.szDocDoId = docDo.szDocId
                LEFT JOIN dms_sd_docinvoiceitemprice AS invoiceItemPrice ON invoice.szDocId = invoiceItemPrice.szDocId AND invoiceItemPrice.intItemNumber = InvoiceItem.intItemNumber
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId

                WHERE invoice.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                    AND invoice.bCash = '0'
                    AND invoice.szDocStatus = 'APPLIED'
                    AND invoice.szBranchId = '$depo'
                    AND (
                        InvoiceItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                        OR InvoiceItem.szUomId IN ('BOX','PCS','PACK')
                    )

                GROUP BY invoice.szDocId
            ) AS subquery
            GROUP BY kategori
            ");

        return view ('bod_2.index',
        [
            'perusahaan' => $perusahaan,
            'monitoring' => $monitoring,
            'segmen' => $segmen,
            'tipe_sales' => $tipe_sales,
            'salesman' => $salesman,
            'gudang_dist' => $gudang_dist,
            'gudang_supp' => $gudang_supp,
            'kasir' => $dataKasir ?? [],
            'pelunasan' => $pelunasan,
            'invoice' => $invoice
        ]);
    }

    public function skujugs(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_jugs = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND (
                    CASE
                        WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                        WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                        ELSE 'OTHER'
                    END = 'JUGS'
                )
            ");

        return view('bod_2_detail.sku_jugs.index', compact('data_jugs'));
    }

    public function skusps(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_sps = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND (
                    CASE
                        WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                        WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                        ELSE 'OTHER'
                    END = 'SPS'
                )
            ");

        return view('bod_2_detail.sku_sps.index', compact('data_sps'));
    }

    public function iod(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_iod = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'IOD'
            ");

        return view('bod_2_detail.segmen_iod.index', compact('data_iod'));
    }

    public function afh(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_afh = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'AFH'
            ");

        return view('bod_2_detail.segmen_afh.index', compact('data_afh'));
    }

    public function ahs(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_ahs = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'AHS'
            ");

        return view('bod_2_detail.segmen_ahs.index', compact('data_ahs'));
    }

    public function mt(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_mt = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'MT'
            ");

        return view('bod_2_detail.segmen_mt.index', compact('data_mt'));
    }

    public function retail(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_retail = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'RETAIL'
            ");

        return view('bod_2_detail.segmen_retail.index', compact('data_retail'));
    }

    public function so(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_so = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'SO'
            ");

        return view('bod_2_detail.segmen_so.index', compact('data_so'));
    }

    public function ws(REQUEST $request)
    {
        $principal = $request->input('principal');
        $entitas = $request->input('kode_perusahaan');
        $depo = $request->input('kode_depo');
        $tgl_dari = $request->input('tgl_dari');
        $sampai_dengan = $request->input('sampai_dengan');


        if($entitas == 'TUA'){
            $connection_db = DB::connection('mysql_tua');
        }elseif($entitas == 'LP'){
            $connection_db = DB::connection('mysql_tu');
        }elseif($entitas == 'WPS'){
            $connection_db = DB::connection('mysql_ta');
        }
    

        $data_ws = $connection_db
            ->select("
                SELECT DISTINCT
                docDo.szBranchId AS 'ID_DEPO',
                REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA_DEPO',
                branch.szCompanyId AS 'ENTITAS',
                DATE(docDo.dtmDoc) AS 'TANGGAL',
                DAY(docDo.dtmDoc) AS 'HARI',
                MONTH(docDo.dtmDoc) AS 'BULAN',
                YEAR(docDo.dtmDoc) AS 'TAHUN',
                docDo.szCustomerId AS 'ID_PELANGGAN',
                customer.szName AS 'NAMA_PELANGGAN',
                hierarchy.szDescription AS 'SEGMEN',
                docDo.szDocId AS 'NO_DO',
                IFNULL (docDo.szEmployeeId, '') AS 'ID_SALESMAN',
                IFNULL (employee.szname, '') AS 'SALESMAN',
                IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                CASE
                WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE_SALES',
                CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END AS 'ID_PRODUK',
                product2.szName AS 'NAMA_PRODUK',

                docDoItem.szOrderItemTypeId AS 'TIPE_PENJUALAN',
                product2.szUomId AS 'SATUAN',
                'PT TIRTA INVESTAMA' AS 'PRINCIPAL',
                CASE
                WHEN docDoItem.szProductId = '10516937' THEN 'AQUA'
                WHEN product2.szName LIKE 'AQ.%' THEN 'AQUA'
                WHEN product2.szName LIKE 'VT.%' THEN 'VIT'
                WHEN product2.szName LIKE 'MIZONE%' THEN 'MIZONE'
                WHEN product2.szName LIKE 'LEVIT%' THEN 'MIZONE'
                ELSE 'OTHER' END AS 'BRAND',
                CASE
                WHEN docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453') THEN 'JUGS'
                WHEN product2.szUomId IN ('BOX','PCS','PACK') THEN 'SPS'
                ELSE 'OTHER' END AS 'SKU',

                CASE
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '124172' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' AND docDoItem.szTrnType = 'RST' THEN CAST(docDoItem.decQty*-1 AS DECIMAL (5,2))
                WHEN docDoItem.szProductId = '74589' THEN CAST(docDoItem.decQty AS DECIMAL (5,2))

                WHEN docDoItem.szTrnType = 'SRE' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'RTR' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                WHEN docDoItem.szTrnType = 'SRT' THEN CAST(docDoItem.decQty*-1/product1.dectobox AS DECIMAL)
                ELSE IFNULL(CAST(docDoItem.decQty/product1.dectobox AS DECIMAL),'') END AS 'QTY',
                CAST(price.decPrice AS DECIMAL) AS 'HARGA',
                CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG_PROMO_TIV',
                CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO_DISTRIBUTOR',
                CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO_INTERNAL',
                CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE_PROMO',
                CAST(price.decAmount AS DECIMAL) AS 'AFTER_PROMO'

                FROM dms_sd_docdo AS docDo

                INNER JOIN dms_sm_branch AS branch ON docDo.szBranchId = branch.szId
                INNER JOIN dms_ar_customer AS customer ON docDo.szCustomerId = customer.szId
                LEFT JOIN dms_pi_employee AS employee ON docDo.szEmployeeId = employee.szId
                INNER JOIN dms_sd_docDoItem AS docDoItem ON docDo.szDocId = docDoItem.szDocId
                INNER JOIN dms_inv_product AS product1 ON docDoItem.szProductId = product1.szId
                INNER JOIN dms_inv_product AS product2 
                ON (CASE 
                WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                ELSE docDoItem.szProductId 
                END) = product2.szId
                LEFT JOIN dms_sd_docdoitemprice AS price ON docDoItem.szDocId = price.szDocId AND price.intItemNumber = docDoItem.intItemNumber
                LEFT JOIN dms_ar_customerhierarchy AS hierarchy ON customer.szHierarchyId = hierarchy.szId

                WHERE docDo.dtmDoc BETWEEN '$tgl_dari' AND '$sampai_dengan'
                AND docDo.szBranchId = '$depo'
                AND docDo.szDocStatus = 'APPLIED'
                AND product2.szName NOT LIKE '%TISSU%'
                AND docDo.szEmployeeId NOT LIKE '%-RNG'
                AND (
                docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                OR product2.szUomId IN ('BOX','PCS','PACK'))
                AND hierarchy.szDescription = 'WS'
            ");

        return view('bod_2_detail.segmen_ws.index', compact('data_ws'));
    }
}


