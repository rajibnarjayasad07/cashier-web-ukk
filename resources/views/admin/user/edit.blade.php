<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 text-gray-300 overflow-hidden shadow-sm sm:rounded-lg p-10">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium">Name</label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" required autofocus>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium">Password</label>
                        <input type="password" name="password" id="password"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md">
                        <small class="text-gray-400">Leave blank if you don't want to change the password.</small>
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium">Role</label>
                        <select id="role" name="role"
                            class="block mt-1 w-full bg-gray-700 text-gray-300 rounded-md"
                            {{ $user->role == 'admin' ? 'disabled' : '' }}>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="cashier" {{ $user->role == 'cashier' ? 'selected' : '' }}>Cashier</option>
                        </select>
                        @if ($user->role == 'admin')
                            <input type="hidden" name="role" value="admin">
                        @endif
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
