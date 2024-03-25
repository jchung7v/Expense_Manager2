<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full mt-4">
                        <thead>
                            <tr>
                                <th class="border-b-2 border-gray-300 py-2">Date</th>
                                <th class="border-b-2 border-gray-300 py-2">Vendor</th>
                                <th class="border-b-2 border-gray-300 py-2">Withdraw</th>
                                <th class="border-b-2 border-gray-300 py-2">Deposit</th>
                                <th class="border-b-2 border-gray-300 py-2">Balance</th>
                                <th class="border-b-2 border-gray-300 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="border-b border-gray-300 py-2">{{ $transaction->date }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ $transaction->vendor }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ number_format((float)$transaction->withdraw, 2) }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ number_format((float)$transaction->deposit, 2) }}</td>
                                    <td class="border-b border-gray-300 py-2">{{ number_format((float)$transaction->balance, 2) }}</td>
                                    <td class="border-b border-gray-300 py-2">
                                        <a href="{{ route('action.get_transaction', $transaction->id) }}" class="text-blue-600">Update</a>
                                        <form action="{{ route('action.delete_transaction', $transaction->id) }}" method="post" class="inline" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete</button>
                                        </form>
                                        <script>
                                            function confirmDelete() {
                                                return confirm('Are you sure you want to delete this transaction?');
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