<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('transaction.store') }}">
                @csrf
                <input type="hidden" name="products" value="{{ json_encode($products) }}">
                <input type="hidden" name="transaction_id" value="{{ $transaction->id ?? '' }}">
                <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg mb-6">
                    <table class="min-w-full text-sm text-left text-gray-400">
                        <thead class="bg-gray-700 text-xs uppercase text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Product</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach ($products as $product)
                                <tr class="border-b border-gray-700">
                                    <td class="px-6 py-4">{{ $product['name'] }}</td>
                                    <td class="px-6 py-4">{{ $product['quantity'] }}</td>
                                    <td class="px-6 py-4">Rp. {{ number_format($product['subtotal'], 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php $totalPrice += $product['subtotal']; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-lg font-semibold text-gray-200 mb-4">
                    Total: Rp. {{ number_format($totalPrice, 0, ',', '.') }}
                </div>
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                <div class="mb-4">
                    <label for="member_status" class="block text-sm font-medium text-gray-200">Member Status</label>
                    <select id="member_status" name="member_status"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md"
                        onchange="toggleMemberInput(this.value)">
                        <option value="non_member">Non-Member</option>
                        <option value="member">Member</option>
                    </select>
                </div>
                <div id="member_phone_input" class="mb-4 hidden">
                    <label for="member_phone" class="block text-sm font-medium text-gray-200">Phone Number</label>
                    <input type="text" id="member_phone" name="member_phone"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="total_payment" class="block text-sm font-medium text-gray-200">Total Payment</label>
                    <input type="text" id="total_payment" name="total_payment"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" required>
                    <p id="payment_error" class="text-sm text-red-500 hidden">Total payment must be greater than or
                        equal to the total price.</p>
                </div>
                <div id="total_return_display" class="text-lg font-semibold text-gray-200 hidden">
                    Total Return: <span id="total_return">Rp. 0</span>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" id="submit_button"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:opacity-50"
                        disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleMemberInput(status) {
            const phoneInput = document.getElementById('member_phone_input');
            phoneInput.classList.toggle('hidden', status !== 'member');
        }

        const totalPaymentInput = document.getElementById('total_payment');
        const paymentError = document.getElementById('payment_error');
        const submitButton = document.getElementById('submit_button');
        const totalPrice = {{ $totalPrice }};

        totalPaymentInput.addEventListener('input', function() {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value) {
                value = parseInt(value, 10);
                this.value = `Rp. ${new Intl.NumberFormat('id-ID').format(value)}`;
            } else {
                this.value = '';
            }

            const numericValue = parseInt(value || 0, 10);
            const totalReturn = numericValue > totalPrice ? numericValue - totalPrice : 0;

            const returnDisplay = document.getElementById('total_return_display');
            const returnValue = document.getElementById('total_return');
            returnDisplay.classList.toggle('hidden', totalReturn === 0);
            returnValue.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(totalReturn)}`;

            const hasError = numericValue < totalPrice;
            paymentError.classList.toggle('hidden', !hasError);
            submitButton.disabled = hasError;
        });
    </script>
</x-app-layout>
