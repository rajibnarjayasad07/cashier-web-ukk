<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4 space-x-4">
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('product.create') }}"
                        class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:bg-gray-700 dark:hover:bg-gray-300">
                        Add Product
                    </a>
                    <a href="{{ route('export.products.excel') }}"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                        Export Excel
                    </a>
                @endif
            </div>
            <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
                <table class="min-w-full text-sm text-left text-gray-400">
                    <thead class="bg-gray-700 text-xs uppercase text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Stock</th>
                            @if (auth()->user()->role == 'admin')
                                <th scope="col" class="px-6 py-3 text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr class="border-b border-gray-700">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/products/' . $product->image) }}"
                                        alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="px-6 py-4">{{ $product->name }}</td>
                                <td class="px-6 py-4">Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $product->stock }}</td>
                                @if (auth()->user()->role == 'admin')
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="text-blue-500 hover:underline">Edit Product</a>
                                            <button
                                                onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})"
                                                class="text-yellow-500 hover:underline">Edit Stock</button>
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Stock Modal -->
    <div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-gray-800 text-gray-300 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-semibold mb-4">Edit Stock</h2>
            <form id="stockForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="productName" class="block text-sm font-medium">Product Name</label>
                    <input type="text" id="productName"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" readonly>
                </div>
                <div class="mb-4">
                    <label for="productStock" class="block text-sm font-medium">Stock</label>
                    <input type="number" id="productStock" name="stock"
                        class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeStockModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md mr-2">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openStockModal(id, name, stock) {
            document.getElementById('stockModal').classList.remove('hidden');
            document.getElementById('stockForm').action = `/product/${id}/update-stock`;
            document.getElementById('productName').value = name;
            document.getElementById('productStock').value = stock;
        }

        function closeStockModal() {
            document.getElementById('stockModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
