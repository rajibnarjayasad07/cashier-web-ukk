<?php 
namespace App\Exports;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, \Maatwebsite\Excel\Concerns\WithEvents
{
    public function collection()
    {
        // return Transaction::select( 'loyalty_points', 'transaction_date', 'total_price', 'total_payment', 'total_return')->get();
        return Transaction::with(['customer', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'Customer',
            'Loyalty Points',
            'Total Price',
            'Total Payment',
            'Total Return',
            'Transaction Date',
            'Cashier',
        ];
    }
    public function map($transaction): array
    {
        return [
            $transaction->customer->name,
            $transaction->loyalty_points,
            'Rp' . number_format($transaction->total_price, 2, ',', '.'),
            'Rp' . number_format($transaction->total_payment, 2, ',', '.'),
            'Rp' . number_format($transaction->total_return, 2, ',', '.'),
            $transaction->transaction_date,
            $transaction->user->name,
        ];
    }
    public function title(): string
    {
        return 'Transactions';
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
