<?php 
namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExport implements FromCollection
{
    public function collection()
    {
        return Transaction::select('transaction_date', 'total_price', 'total_payment', 'total_return')->get();
    }
}
