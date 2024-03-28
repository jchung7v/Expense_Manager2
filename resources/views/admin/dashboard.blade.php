<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as admin") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-fixed text-center w-full mt-4">
                        <thead>
                            <tr>
                                <th class="border-b-2 border-gray-300 py-2">Name</th>
                                <th class="border-b-2 border-gray-300 py-2">Email</th>
                                <th class="border-b-2 border-gray-300 py-2">Role</th>
                                <th class="border-b-2 border-gray-300 py-2">Role Switch</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border-b border-gray-300 py-2">{{ $user->name }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ $user->email }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ $user->role }}</td>
                                    <td>
                                        <form action="{{ route('admin.update_role', $user->id) }}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" required>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                            <button type="submit" class="bg-transparent text-blue-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                                Save
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>