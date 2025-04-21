<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use App\Exports\ProductsExport;
use Mpdf\Mpdf;

class ExportController extends Controller
{
    public function downloadInvoicePdf($id)
    {
        $transaction = Transaction::with(['customer', 'user', 'detailTransaction.product'])->findOrFail($id);

        $mpdf = new \Mpdf\Mpdf();
        $html = view('exports.invoice-pdf', compact('transaction'))->render();
        $mpdf->WriteHTML($html);
        return response()->streamDownload(
            fn () => $mpdf->Output(),
            "invoice-transaction-{$id}.pdf"
        );
    }

    public function exportTransactionsExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }

    public function exportProductsExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
