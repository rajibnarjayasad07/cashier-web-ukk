<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 text-gray-300 overflow-hidden shadow-sm sm:rounded-lg p-10">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input type="text" name="name" id="name" value="{{ $product->name }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium">Price</label>
                        <input type="number" name="price" id="price" value="{{ $product->price }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="stock" class="block text-sm font-medium">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ $product->stock }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium">Image</label>
                        <input type="file" name="image" id="image"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
