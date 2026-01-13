<?php

namespace App\Http\Controllers\Module\Summary;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Helpers\TelegramLogHelper;
use App\Helpers\FileLogHelper;


class PenjualanController extends Controller
{
    public function index()
    {
        return view('bod_2.penjualan');
    }

    public function data(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'company' => 'required|string',
            'branch'  => 'required|string',
            'month' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation error.',
                'error'   => $validator->errors()
            ]);
        }

        try {
            $company = $request->input('company');
            $branch  = $request->input('branch');
            $month  = $request->input('month');
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth()->toDateString(); // "2025-06-01"
            $endDate = Carbon::createFromFormat('Y-m', $month)->endOfMonth()->toDateString(); // "2025-06-30"
            // dd($startDate);
            $query = DB::connection('mysql_ta')
                ->select("SELECT DISTINCT
                        docDo.szBranchId AS 'ID DEPO',
                        REPLACE(REPLACE(REPLACE(branch.szName, 'TUA','DEPO'),'LP','DEPO'),'WPS','DEPO') AS 'NAMA DEPO',
                        branch.szCompanyId AS 'ENTITAS',
                        DATE(docDo.dtmDoc) AS 'TANGGAL',
                        DAY(docDo.dtmDoc) AS 'HARI',
                        MONTH(docDo.dtmDoc) AS 'BULAN',
                        YEAR(docDo.dtmDoc) AS 'TAHUN',
                        docDo.szCustomerId AS 'ID PELANGGAN',
                        customer.szName AS 'NAMA PELANGGAN',
                        hierarchy.szDescription AS 'SEGMEN',
                        docDo.szDocId AS 'NO_DO',
                        IFNULL (docDo.szEmployeeId, '') AS 'ID SALESMAN',
                        IFNULL (employee.szname, '') AS 'SALESMAN',
                        IFNULL (docDo.szVehicleId, '') AS 'KENDARAAN',
                        CASE
                        WHEN docDo.bCash = '1' THEN 'TUNAI' ELSE 'KREDIT' END AS 'TIPE SALES',
                        CASE 
                        WHEN RIGHT(docDoItem.szProductId, 1) = 'P' 
                        THEN LEFT(docDoItem.szProductId, CHAR_LENGTH(docDoItem.szProductId) - 1)
                        ELSE docDoItem.szProductId 
                        END AS 'ID PRODUK',
                        product2.szName AS 'NAMA PRODUK',

                        docDoItem.szOrderItemTypeId AS 'TIPE PENJUALAN',
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
                        CAST(price.decDiscPrinciple AS DECIMAL) AS 'PIUTANG PROMO TIV',
                        CAST(price.decDiscDistributor AS DECIMAL) AS 'PROMO DISTRIBUTOR',
                        CAST(price.decDiscInternal AS DECIMAL) AS 'PROMO INTERNAL',
                        CAST(price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'TOTAL PROMO', 
                        CAST(price.decAmount + price.decDiscDistributor + price.decDiscPrinciple + price.decDiscInternal AS DECIMAL) AS 'BEFORE PROMO',
                        CAST(price.decAmount AS DECIMAL) AS 'AFTER PROMO'

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

                        WHERE docDo.dtmDoc BETWEEN '$startDate' AND '$endDate'
                        AND docDo.szBranchId = '$branch'
                        AND docDo.szDocStatus = 'APPLIED'
                        AND product2.szName NOT LIKE '%TISSU%'
                        AND docDo.szEmployeeId NOT LIKE '%-RNG'
                        AND (
                        docDoItem.szProductId IN ('74559','74560','10169933','10169932','10516937','10438453')
                        OR product2.szUomId IN ('BOX','PCS','PACK'))");

            // dd($query);

            return response()->json([
                'status' => true,
                'message' => 'Data Penjualan',
                'data' => $query,

            ]);
            // dd($query);
        } catch (\Exception $e) {
            $errorData = [
                'status' => 'error',
                'method' => 'get_data_monitoring',
                'module' => 'MonitoringController',
                'data'   => [
                    'error' => $e->getMessage(),
                    'file'  => $e->getFile(),
                    'line'  => $e->getLine()
                ]
            ];

            return response()->json([
                'status'  => false,
                'message' => 'Failed to view data',
                'error'   => 'An internal error occurred. Check the log file.'
            ]);
        }
    }
}
