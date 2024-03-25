<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>

            </div>
            <form action="{{ route('expenses.import') }}" method="post" enctype="multipart/form-data" class="p-3 bg-grey">
                @csrf
                <div class="mb-3">
                    <label for="fileToUpload" class="form-label">Select file to upload:</label>
                    <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Upload Selected File</button>
            </form>
        </div>
    </div>

    @if (session('success'))
    <script>
        window.onload = function() {
            alert('{{ session('success') }}');
        };
    </script>
    @endif

</x-app-layout>
