<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Choose Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('transaction.index') }}"
                class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:bg-gray-700 dark:hover:bg-gray-300 mb-4 inline-block">
                Back
            </a>
            @if ($products->isEmpty())
                <div class="text-center text-gray-500">
                    No products available.
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-gray-800 rounded-lg shadow-lg p-4">
                            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover rounded">
                            <h3 class="text-lg font-semibold text-gray-200 mt-4">{{ $product->name }}</h3>
                            <p class="text-gray-400">Price: Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class="text-gray-400">Stock: {{ $product->stock }}</p>
                            <div class="flex items-center mt-4 space-x-2">
                                <button
                                    onclick="decrementQuantity({{ $product->id }}, {{ $product->stock }}, {{ $product->price }})"
                                    class="px-3 py-2 bg-red-500 text-white rounded-l hover:bg-red-600">-</button>
                                <input type="number" id="quantity-{{ $product->id }}" value="0" min="0"
                                    class="w-16 text-center bg-gray-700 text-white rounded" readonly>
                                <button
                                    onclick="incrementQuantity({{ $product->id }}, {{ $product->stock }}, {{ $product->price }})"
                                    class="px-3 py-2 bg-green-500 text-white rounded-r hover:bg-green-600">+</button>
                            </div>
                            <p class="text-gray-400 mt-2">Subtotal: <span id="subtotal-{{ $product->id }}">Rp.
                                    0</span></p>
                        </div>
                    @endforeach
                </div>
                <div class="sticky bottom-0 bg-gray-900 p-4 rounded-t-lg shadow-lg flex justify-between items-center">
                    <div class="text-lg font-semibold text-gray-200">
                        Total: <span id="total-price">Rp. 0</span>
                    </div>
                    <button onclick="redirectToDetailTransaction()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Next</button>
                </div>
            @endif
        </div>
    </div>

    <script>
        let totalPrice = 0;

        function incrementQuantity(productId, stock, price) {
            const input = document.getElementById(`quantity-${productId}`);
            const subtotalElement = document.getElementById(`subtotal-${productId}`);
            let quantity = parseInt(input.value);

            if (quantity < stock) {
                quantity++;
                input.value = quantity;
                const subtotal = quantity * price;
                subtotalElement.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                updateTotalPrice(price);
            } else {
                alert('Quantity exceeds available stock!');
            }
        }

        function decrementQuantity(productId, stock, price) {
            const input = document.getElementById(`quantity-${productId}`);
            const subtotalElement = document.getElementById(`subtotal-${productId}`);
            let quantity = parseInt(input.value);

            if (quantity > 0) {
                quantity--;
                input.value = quantity;
                const subtotal = quantity * price;
                subtotalElement.textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(subtotal)}`;
                updateTotalPrice(-price);
            }
        }

        function updateTotalPrice(amount) {
            totalPrice += amount;
            document.getElementById('total-price').textContent = `Rp. ${new Intl.NumberFormat('id-ID').format(totalPrice)}`;
        }

        function redirectToDetailTransaction() {
            const quantities = {};
            document.querySelectorAll('input[id^="quantity-"]').forEach(input => {
                const productId = input.id.split('-')[1];
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    quantities[productId] = quantity;
                }
            });

            if (Object.keys(quantities).length === 0) {
                alert('Please select at least one product.');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('transaction.detail') }}';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="products" value='${JSON.stringify(quantities)}'>
            `;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</x-app-layout>
