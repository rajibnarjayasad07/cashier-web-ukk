<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4 space-x-4">
                @if (auth()->user()->role == 'cashier')
                    <a href="{{ route('transaction.create') }}"
                        class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:bg-gray-700 dark:hover:bg-gray-300">
                        Create Transaction
                    </a>
                @endif
                <a href="{{ route('export.transactions.excel') }}"
                    class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                    Export Excel
                </a>
            </div>
            <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
                <table class="min-w-full text-sm text-left text-gray-400">
                    <thead class="bg-gray-700 text-xs uppercase text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Customer Name</th>
                            <th scope="col" class="px-6 py-3">Cashier</th>
                            <th scope="col" class="px-6 py-3">Transaction Date</th>
                            <th scope="col" class="px-6 py-3">Total Payment</th>
                            <th scope="col" class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr class="border-b border-gray-700">
                                <td class="px-6 py-4">{{ $transaction->customer->name }}</td>
                                <td class="px-6 py-4">{{ $transaction->user->name }}</td>
                                <td class="px-6 py-4">{{ $transaction->transaction_date }}</td>
                                <td class="px-6 py-4">Rp. {{ number_format($transaction->total_payment, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('transaction.invoice', $transaction->id) }}"
                                            class="text-blue-500 hover:underline">Lihat</a>
                                        <a href="{{ route('export.transaction.invoice-pdf', $transaction->id) }}"
                                            class="text-green-500 hover:underline">Unduh Bukti</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
