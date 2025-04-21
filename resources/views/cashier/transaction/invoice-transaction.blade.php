<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6">
                <!-- Alert Section -->
                @if (session('success'))
                    <div class="mb-4 p-4 text-green-800 bg-green-200 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-4 text-red-800 bg-red-200 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <h3 class="text-lg font-semibold text-gray-200 mb-4">Transaction Summary</h3>
                <p class="text-gray-400">Transaction Date: {{ $transaction->transaction_date }}</p>
                <p class="text-gray-400">Cashier: {{ $transaction->user->name }}</p>

                <!-- Member Information Section -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-200 mb-4">Member Information</h4>
                    <p class="text-gray-400">Customer Name: {{ $transaction->customer->name ?? 'Non-Member' }}</p>
                    <p class="text-gray-400">Phone: {{ $transaction->customer->phone ?? '-' }}</p>
                    <span
                        class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $transaction->customer->id != 0 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                        {{ $transaction->customer->id != null ? 'Member' : 'Non-Member' }}
                    </span>
                </div>

                <!-- Points Section -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-200 mb-4">Points</h4>
                    <p class="text-gray-400">Points Used: {{ $transaction->total_point }}</p>
                    <p class="text-gray-400">Points Earned: {{ $transaction->loyalty_points }}</p>
                </div>

                <!-- Total Price Section -->
                <div class="mt-6">
                    <h4 class="text-lg font-semibold text-gray-200 mb-4">Total</h4>
                    <p class="text-gray-400">Total Price: Rp.
                        {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    <p class="text-gray-400">Total Payment: Rp.
                        {{ number_format($transaction->total_payment, 0, ',', '.') }}</p>
                    <p class="text-gray-400">Total Return: Rp.
                        {{ number_format($transaction->total_return, 0, ',', '.') }}</p>
                </div>

                <!-- Purchased Products Section -->
                <h4 class="text-lg font-semibold text-gray-200 mt-6 mb-4">Purchased Products</h4>
                <div class="overflow-x-auto bg-gray-700 rounded-lg shadow-lg">
                    <table class="min-w-full text-sm text-left text-gray-400">
                        <thead class="bg-gray-600 text-xs uppercase text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Product Name</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->detailTransaction as $detail)
                                <tr class="border-b border-gray-600">
                                    <td class="px-6 py-4">{{ $detail->product->name }}</td>
                                    <td class="px-6 py-4">{{ $detail->amount }}</td>
                                    <td class="px-6 py-4">Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('transaction.index') }}"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Back to Transactions</a>
                    <a href="{{ route('export.transaction.invoice-pdf', $transaction->id) }}" 
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Print Invoice</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
