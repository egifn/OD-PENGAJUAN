<?php

namespace App\Http\Controllers\Rekon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Perusahaan;
use Carbon\carbon;
use Auth;
use DB;

class MonitoringController extends Controller
{
	public function ajax_depo(Request $request)
	{
		$kodedepo = Depo::where('kode_perusahaan', $request->perusahaan_id)->pluck('kode_depo','nama_depo');
        return response()->json($kodedepo);
	}

    public function index()
    {
    	$perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

    	$monitoring = DB::connection('mysql_tua')
    		->select("SELECT DISTINCT branch.szId AS 'ID_DEPO',
					branch.szName AS 'NAMA_DEPO',
					DATE (bgReceipt.dtmDoc) AS 'TGGL_PENERIMAAN_CEK',
					bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
					bgReceiptItem.intItemNumber AS 'INT1',
					bgReceiptItem.szRefDocId AS 'NO_CEK',
					bgReceiptItem.szBankId AS 'BANK',
					bgReceipt.szEmployeeId AS 'ID_SALES',
					employee.szName AS 'NAMA_SALES',
					bgReceipt.szAccountId AS 'NO_AKUN',
					account1.szName AS 'NAMA_AKUN',
					bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
					account2.szName AS 'NAMA_AKUN_KLIRING',
					bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
					customer1.szName AS 'NAMA_PELANGGAN_CEK',
					CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
					bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
					bg.szStatus AS 'STATUS_CEK',
					bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
					IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
					IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
					CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
					IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
					IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
					CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
					IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
					IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
					IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
					IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
					IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
					IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
					IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
					IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
					IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
					IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
					CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
					FROM dms_cas_docbgreceiptitem AS bgReceiptItem
					INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
					INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
					INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
					INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
					LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
					LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
					LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
					LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
					LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
					LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
					LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
					LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
					LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
					LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
					LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
					LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
					LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
					LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
					WHERE bgReceipt.dtmDoc BETWEEN '-' AND '-'
					AND branch.szId = 'request()->depo'");

    	return view('rekon.monitoring.index', compact('perusahaan','monitoring'));
    }

    public function index_cari(Request $request)
    {
    	$perusahaan = Perusahaan::orderBy('kode_perusahaan', 'ASC')->get();

        if(request()->created_at != ''){
            $date = explode(' - ' ,request()->created_at);
            $start_date = Carbon::parse($date[0])->format('Y-m-d');
            $end_date = Carbon::parse($date[1])->format('Y-m-d');
        }

        if(request()->perusahaan == ''){

        }elseif(request()->perusahaan == 'TUA'){
        	if(request()->depo != ''){
        		$depo = request()->depo;

        		$monitoring = DB::connection('mysql_tua')
	    		->select("SELECT DISTINCT branch.szId AS 'ID_DEPO',
						branch.szName AS 'NAMA_DEPO',
						DATE (bgReceipt.dtmDoc) AS 'TGGL_PENERIMAAN_CEK',
						bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
						bgReceiptItem.intItemNumber AS 'INT1',
						bgReceiptItem.szRefDocId AS 'NO_CEK',
						bgReceiptItem.szBankId AS 'BANK',
						bgReceipt.szEmployeeId AS 'ID_SALES',
						employee.szName AS 'NAMA_SALES',
						bgReceipt.szAccountId AS 'NO_AKUN',
						account1.szName AS 'NAMA_AKUN',
						bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
						account2.szName AS 'NAMA_AKUN_KLIRING',
						bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
						customer1.szName AS 'NAMA_PELANGGAN_CEK',
						CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
						bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
						bg.szStatus AS 'STATUS_CEK',
						bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
						IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
						IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
						CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
						IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
						IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
						CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
						IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
						IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
						IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
						IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
						IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
						IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
						IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
						IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
						IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
						IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
						CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
						FROM dms_cas_docbgreceiptitem AS bgReceiptItem
						INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
						INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
						INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
						INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
						LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
						LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
						LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
						LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
						LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
						LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
						LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
						LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
						LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
						LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
						LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
						LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
						LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
						LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
						WHERE bgReceipt.dtmDoc BETWEEN '$start_date' AND '$end_date'
						AND branch.szId = '$depo'");
        	}else{
        		$monitoring = DB::connection('mysql_tua')
	    		->select("SELECT DISTINCT branch.szId AS 'ID_DEPO',
						branch.szName AS 'NAMA_DEPO',
						DATE (bgReceipt.dtmDoc) AS 'TGGL_PENERIMAAN_CEK',
						bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
						bgReceiptItem.intItemNumber AS 'INT1',
						bgReceiptItem.szRefDocId AS 'NO_CEK',
						bgReceiptItem.szBankId AS 'BANK',
						bgReceipt.szEmployeeId AS 'ID_SALES',
						employee.szName AS 'NAMA_SALES',
						bgReceipt.szAccountId AS 'NO_AKUN',
						account1.szName AS 'NAMA_AKUN',
						bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
						account2.szName AS 'NAMA_AKUN_KLIRING',
						bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
						customer1.szName AS 'NAMA_PELANGGAN_CEK',
						CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
						bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
						bg.szStatus AS 'STATUS_CEK',
						bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
						IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
						IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
						CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
						IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
						IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
						CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
						IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
						IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
						IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
						IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
						IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
						IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
						IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
						IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
						IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
						IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
						CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
						FROM dms_cas_docbgreceiptitem AS bgReceiptItem
						INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
						INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
						INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
						INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
						LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
						LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
						LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
						LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
						LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
						LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
						LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
						LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
						LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
						LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
						LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
						LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
						LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
						LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
						WHERE bgReceipt.dtmDoc BETWEEN '$start_date' AND '$end_date'");
        	}
        }elseif(request()->perusahaan == 'LP'){
        	if($depo != ''){
        		$depo = request()->depo;

        		$monitoring = DB::connection('mysql_tua')
	    		->select("SELECT DISTINCT branch.szId AS ID_DEPO,
						branch.szName AS NAMA_DEPO,
						DATE (bgReceipt.dtmDoc) AS TGGL_PENERIMAAN_CEK,
						bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
						bgReceiptItem.intItemNumber AS 'INT1',
						bgReceiptItem.szRefDocId AS 'NO_CEK',
						bgReceiptItem.szBankId AS 'BANK',
						bgReceipt.szEmployeeId AS 'ID_SALES',
						employee.szName AS 'NAMA_SALES',
						bgReceipt.szAccountId AS 'NO_AKUN',
						account1.szName AS 'NAMA_AKUN',
						bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
						account2.szName AS 'NAMA_AKUN_KLIRING',
						bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
						customer1.szName AS 'NAMA_PELANGGAN_CEK',
						CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
						bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
						bg.szStatus AS 'STATUS_CEK',
						bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
						IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
						IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
						CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
						IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
						IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
						CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
						IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
						IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
						IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
						IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
						IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
						IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
						IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
						IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
						IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
						IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
						CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
						FROM dms_cas_docbgreceiptitem AS bgReceiptItem
						INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
						INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
						INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
						INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
						LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
						LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
						LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
						LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
						LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
						LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
						LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
						LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
						LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
						LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
						LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
						LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
						LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
						LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
						WHERE bgReceipt.dtmDoc BETWEEN '$start_date' AND '$end_date'
						AND branch.szId = '$depo'");
        	}else{
        		$monitoring = DB::connection('mysql_tua')
	    		->select("SELECT DISTINCT branch.szId AS 'ID_DEPO',
						branch.szName AS 'NAMA_DEPO',
						DATE (bgReceipt.dtmDoc) AS 'TGGL_PENERIMAAN_CEK',
						bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
						bgReceiptItem.intItemNumber AS 'INT1',
						bgReceiptItem.szRefDocId AS 'NO_CEK',
						bgReceiptItem.szBankId AS 'BANK',
						bgReceipt.szEmployeeId AS 'ID_SALES',
						employee.szName AS 'NAMA_SALES',
						bgReceipt.szAccountId AS 'NO_AKUN',
						account1.szName AS 'NAMA_AKUN',
						bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
						account2.szName AS 'NAMA_AKUN_KLIRING',
						bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
						customer1.szName AS 'NAMA_PELANGGAN_CEK',
						CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
						bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
						bg.szStatus AS 'STATUS_CEK',
						bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
						IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
						IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
						CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
						IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
						IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
						CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
						IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
						IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
						IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
						IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
						IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
						IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
						IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
						IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
						IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
						IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
						CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
						FROM dms_cas_docbgreceiptitem AS bgReceiptItem
						INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
						INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
						INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
						INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
						LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
						LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
						LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
						LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
						LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
						LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
						LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
						LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
						LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
						LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
						LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
						LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
						LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
						LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
						WHERE bgReceipt.dtmDoc BETWEEN '$start_date' AND '$end_date'");
        	}
        }elseif(request()->perusahaan == 'WPS'){
        	if(request()->depo != ''){
        		$depo = request()->depo;

        		$monitoring = DB::connection('mysql_tua')
	    		->select("SELECT DISTINCT branch.szId AS 'ID_DEPO',
						branch.szName AS 'NAMA_DEPO',
						DATE (bgReceipt.dtmDoc) AS 'TGGL_PENERIMAAN_CEK',
						bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
						bgReceiptItem.intItemNumber AS 'INT1',
						bgReceiptItem.szRefDocId AS 'NO_CEK',
						bgReceiptItem.szBankId AS 'BANK',
						bgReceipt.szEmployeeId AS 'ID_SALES',
						employee.szName AS 'NAMA_SALES',
						bgReceipt.szAccountId AS 'NO_AKUN',
						account1.szName AS 'NAMA_AKUN',
						bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
						account2.szName AS 'NAMA_AKUN_KLIRING',
						bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
						customer1.szName AS 'NAMA_PELANGGAN_CEK',
						CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
						bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
						bg.szStatus AS 'STATUS_CEK',
						bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
						IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
						IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
						CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
						IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
						IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
						CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
						IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
						IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
						IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
						IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
						IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
						IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
						IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
						IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
						IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
						IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
						CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
						FROM dms_cas_docbgreceiptitem AS bgReceiptItem
						INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
						INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
						INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
						INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
						LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
						LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
						LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
						LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
						LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
						LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
						LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
						LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
						LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
						LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
						LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
						LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
						LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
						LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
						WHERE bgReceipt.dtmDoc BETWEEN '$start_date' AND '$end_date'
						AND branch.szId = '$depo'");
        	}else{
        		$monitoring = DB::connection('mysql_tua')
	    		->select("SELECT DISTINCT branch.szId AS 'ID_DEPO',
						branch.szName AS 'NAMA_DEPO',
						DATE (bgReceipt.dtmDoc) AS 'TGGL_PENERIMAAN_CEK',
						bgReceiptItem.szDocId AS 'DOK_PENERIMAAN_CEK',
						bgReceiptItem.intItemNumber AS 'INT1',
						bgReceiptItem.szRefDocId AS 'NO_CEK',
						bgReceiptItem.szBankId AS 'BANK',
						bgReceipt.szEmployeeId AS 'ID_SALES',
						employee.szName AS 'NAMA_SALES',
						bgReceipt.szAccountId AS 'NO_AKUN',
						account1.szName AS 'NAMA_AKUN',
						bgReceipt.szAccountClearingId AS 'NO_AKUN_KLIRING',
						account2.szName AS 'NAMA_AKUN_KLIRING',
						bgReceiptItem.szCustomerId AS 'ID_PELANGGAN_CEK',
						customer1.szName AS 'NAMA_PELANGGAN_CEK',
						CAST(bgReceiptItem.decAmount AS DECIMAL) AS 'NILAI_CEK',
						bgReceiptItem.dtmDue AS 'TGGL_JTH_TEMPO_CEK',
						bg.szStatus AS 'STATUS_CEK',
						bgReceipt.szDocStatus AS 'STATUS_DOK_CEK',
						IFNULL(bgPayment.szRefDocId, '') AS 'DOK_PAYMENT',
						IFNULL(bgPayment.szRefInvoiceId, '') AS 'NO_INVOICE',
						CAST(IFNULL(invoice.decAmount, '') AS DECIMAL) AS 'NILAI_INVOICE',
						IFNULL(bgPayment.szRefCustomerId, '') AS 'ID_PELANGGAN_PAYMENT',
						IFNULL(customer3.szName, '') AS 'NAMA_PELANGGAN_PAYMENT',
						CAST(IFNULL(bgPayment.decAmount, '') AS DECIMAL) AS 'NILAI_PAYMENT',
						IFNULL(bgPayment.szPaymentType, '') AS 'TIPE_PEMBAYARAN',
						IFNULL(payment.szDocStatus, '') AS 'STATUS_DOK_PAYMENT',
						IFNULL (bgDeposit.szDocId, '0') AS 'DOK_PENYETORAN',
						IFNULL (bgDeposit.dtmDoc, '0') AS 'TGGL_PENYETORAN',
						IFNULL (bgDeposit.szDocStatus, '0') AS 'STATUS_DOK_PENYETORAN',
						IFNULL (clearingItem.szDocId, '0') AS 'DOK_KLIRING',
						IFNULL (clearingItem.intItemNumber, '0') AS 'INT2',
						IFNULL (DATE (clearing.dtmDoc), '0') AS 'TGGL_KLIRING',
						IFNULL (clearing.szDocStatus, '0') AS 'STATUS_DOK_KLIRING',
						IFNULL (bg.szDocRejectId, '0') AS 'DOK_REJECT',
						CASE WHEN bg.szDocRejectId = '' THEN bg.dtmReject = '0' ELSE (DATE (bg.dtmReject)) END AS 'TGGL_REJECT'
						FROM dms_cas_docbgreceiptitem AS bgReceiptItem
						INNER JOIN dms_cas_docbgreceipt AS bgReceipt ON bgReceiptItem.szDocId = bgReceipt.szDocId
						INNER JOIN dms_sm_branch AS branch ON bgReceipt.szBranchId = branch.szId
						INNER JOIN dms_ar_customer AS customer1 ON bgReceiptItem.szCustomerId = customer1.szId
						INNER JOIN dms_pi_employee AS employee ON bgreceipt.szEmployeeId = employee.szId
						LEFT JOIN dms_cas_bgpayment AS bgPayment ON bgreceiptitem.szRefDocId = bgPayment.szId
						LEFT JOIN dms_ar_customer AS customer2 ON bgPayment.szCustomerId = customer2.szId
						LEFT JOIN dms_ar_customer AS customer3 ON bgPayment.szRefCustomerId = customer3.szId
						LEFT JOIN dms_ar_arinvoice AS invoice ON bgPayment.szRefInvoiceId = invoice.szDocId
						LEFT JOIN dms_cas_docbgclearingitem AS clearingItem ON bgReceiptItem.szRefDocId = clearingItem.szRefDocId
						LEFT JOIN dms_cas_docbgclearing AS clearing ON clearingItem.szDocId = clearing.szDocId
						LEFT JOIN dms_cas_bg AS bg ON bgReceiptItem.szRefDocId = bg.szId
						LEFT JOIN dms_fin_account AS account1 ON bgReceipt.szAccountId = account1.szId
						LEFT JOIN dms_fin_account AS account2 ON bgReceipt.szAccountClearingId = account2.szId
						LEFT JOIN dms_cas_docbgdepositItem AS bgDepositItem ON bgReceiptItem.szRefDocId = bgDepositItem.szRefDocId
						LEFT JOIN dms_cas_docbgdeposit AS bgDeposit ON bgDepositItem.szDocId= bgDeposit.szDocId
						LEFT JOIN dms_ar_docpayment AS payment ON bgPayment.szRefDocId = payment.szDocId
						LEFT JOIN dms_ar_docpaymentitemdetail AS paymentitem ON bgPayment.szRefDocId = paymentitem.szDocId
						LEFT JOIN dms_ar_customer AS customer4 ON clearingItem.szCustomerId = customer4.szId
						WHERE bgReceipt.dtmDoc BETWEEN '$start_date' AND '$end_date'");
        	}
        }

    	return view('rekon.monitoring.index', compact('perusahaan','monitoring'));
    }
}
