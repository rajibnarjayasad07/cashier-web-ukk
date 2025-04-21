<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Sales per day for the current month
        $salesPerDay = Transaction::selectRaw('DATE(transaction_date) as date, SUM(total_price) as total')
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Sales count per product
        $productSales = DetailTransaction::selectRaw('product_id, SUM(amount) as total_sales')
            ->groupBy('product_id')
            ->with('product:id,name')
            ->get();

        return view('dashboard', compact('salesPerDay', 'productSales'));
    }
}
