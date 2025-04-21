<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
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
            <div class="flex justify-end mb-4">
                <a href="{{ route('users.create') }}"
                    class="px-4 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-md hover:bg-gray-700 dark:hover:bg-gray-300">
                    Add User
                </a>
            </div>
            <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-lg">
                <table class="min-w-full text-sm text-left text-gray-400">
                    <thead class="bg-gray-700 text-xs uppercase text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Role</th>
                            <th scope="col" class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr class="border-b border-gray-700">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->role }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="text-blue-500 hover:underline">Edit</a>
                                        @if ($user->role == 'cashier')
                                            <button onclick="confirmDelete({{ $user->id }})"
                                                class="text-red-500 hover:underline">Delete</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-gray-800 text-gray-300 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
            <p>Are you sure you want to delete this user?</p>
            <div class="flex justify-end mt-4">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md mr-2">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/users/${id}/delete`; // Update route to match the delete route
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
