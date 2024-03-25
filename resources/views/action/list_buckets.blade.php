<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bucket List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full mt-4">
                        <thead>
                            <tr>
                                <th class="border-b-2 border-gray-300 py-2">Cateogory</th>
                                <th class="border-b-2 border-gray-300 py-2">Vendor</th>
                                <th class="border-b-2 border-gray-300 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buckets as $bucket)
                                <tr>
                                    <td class="border-b border-gray-300 py-2">{{ $bucket->category }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ $bucket->vendor }}</td>
                                    <td class="border-b border-gray-300 py-2">
                                        <a href="{{ route('action.get_bucket', $bucket->id) }}" class="text-blue-600">Update</a>
                                        <form action="{{ route('action.delete_bucket', $bucket->id) }}" method="post" class="inline" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete</button>
                                        </form>
                                        <script>
                                            function confirmDelete() {
                                                return confirm('Are you sure you want to delete this bucket?');
                                            }
                                        </script>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-app-layout>