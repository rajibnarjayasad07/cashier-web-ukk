<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Member Identity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-start mb-4">
                <form method="POST" action="{{ route('transaction.cancel', $transaction->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Cancel
                        Transaction</button>
                </form>
            </div>
            <form method="POST" action="{{ route('transaction.update-member') }}">
                @csrf
                <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                <input type="hidden" name="total_price" value="{{ $transaction->total_price }}">
                <input type="hidden" name="total_payment" value="{{ $transaction->total_payment }}">
                <input type="hidden" name="total_return" value="{{ $transaction->total_return }}">
                <div class="mb-4">
                    <label for="member_name" class="block text-sm font-medium text-gray-200">Member Name</label>
                    <input type="text" id="member_name" name="member_name" value="{{ $customer->name ?? '' }}"
                        placeholder="{{ $customer->name ?? 'Tambahkan identitas disini untuk mendaftar' }}"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md"
                        {{ $customer ? 'readonly' : '' }}>
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-200">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ $phone }}"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" readonly>
                </div>
                @if ($customer)
                    <div class="mb-4">
                        <label for="loyalty_points" class="block text-sm font-medium text-gray-200">Loyalty
                            Points</label>
                        <input type="number" id="loyalty_points" name="loyalty_points"
                            value="{{ $customer->loyalty_points }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="use_points" class="block text-sm font-medium text-gray-200">Use Points</label>
                        <input type="number" id="use_points" name="use_points" max="{{ $customer->loyalty_points }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md">
                    </div>
                @endif
                <div class="mb-4">
                    <label for="points_earned" class="block text-sm font-medium text-gray-200">Points Earned</label>
                    <input type="number" id="points_earned" name="points_earned"
                        value="{{ floor($transaction->total_price * 0.01) }}"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" readonly>
                </div>

                <h4 class="text-lg font-semibold text-gray-200 mt-6 mb-4">Purchased Products</h4>
                <div class="overflow-x-auto bg-gray-700 rounded-lg shadow-lg mb-4">
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
                <div class="text-lg font-semibold text-gray-200 mb-4">
                    Total Price: Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Update Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
