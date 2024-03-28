<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Bucket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('action.update_bucket', $bucket->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                            <input type="text" name="category" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $bucket->category }}">
                        </div>
                        <div class="mb-4">
                            <label for="vendor" class="block text-gray-700 text-sm font-bold mb-2">Vendor</label>
                            <input type="text" name="vendor" id="vendor" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $bucket->vendor }}">
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Save
                        </button>
                        <button type="button" onclick="window.location='{{ route('action.list_buckets') }}'" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Cancel
                        </button>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>