<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($history->id) ? __('Transaction Details') : __('Transaction History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Single Transaction Detail View -->
            @if(isset($history->id))
                <div class="mb-4">
                    <a href="{{ route('history.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded hover:bg-gray-300">
                        &larr; Back to History
                    </a>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Transaction Information</h3>
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="border rounded p-4">
                                    <p class="text-sm text-gray-600">Transaction ID</p>
                                    <p class="font-medium">{{ $history->id }}</p>
                                </div>
                                <div class="border rounded p-4">
                                    <p class="text-sm text-gray-600">Date</p>
                                    <p class="font-medium">{{ $history->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="border rounded p-4">
                                    <p class="text-sm text-gray-600">Total Amount</p>
                                    <p class="font-medium">Rp {{ number_format($history->total, 0, ',', '.') }}</p>
                                </div>
                                <div class="border rounded p-4">
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p class="font-medium">
                                        @if($history->status == 0 || !isset($history->status))
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pending</span>
                                        @elseif($history->status == 1)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Completed</span>
                                        @elseif($history->status == 2)
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Cancelled</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Ticket Items</h3>
                            <div class="mt-4 overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 text-left">Ticket</th>
                                            <th class="py-3 px-4 text-left">Quantity</th>
                                            <th class="py-3 px-4 text-left">Price</th>
                                            <th class="py-3 px-4 text-left">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($history->historyItems as $item)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 px-4">{{ $item->ticket->name ?? 'Unknown Ticket' }}</td>
                                                <td class="py-3 px-4">{{ $item->qty }}</td>
                                                <td class="py-3 px-4">Rp {{ number_format($item->ticket->price ?? 0, 0, ',', '.') }}</td>
                                                <td class="py-3 px-4">Rp {{ number_format(($item->qty * ($item->ticket->price ?? 0)), 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3" class="py-3 px-4 text-right font-medium">Total:</td>
                                            <td class="py-3 px-4 font-medium">Rp {{ number_format($history->total, 0, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        @if(!isset($history->status) || $history->status == 0)
                            <div class="mt-8 border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Actions</h3>
                                
                                <!-- Upload Payment Proof Form -->
                                <div class="mb-6">
                                    <h4 class="font-medium mb-2">Upload Payment Proof</h4>
                                    <form action="{{ route('history.uploadImage', $history->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <div>
                                            <input type="file" name="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                            @error('file')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            Upload Image
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Update Payment Status Form -->
                                <div>
                                    <h4 class="font-medium mb-2">Update Payment Status</h4>
                                    <form action="{{ route('history.reqPayment', $history->id) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @method('PUT')
                                        <div>
                                            <select name="status" class="block w-full p-2 border border-gray-300 rounded-md">
                                                <option value="0" selected>Pending</option>
                                                <option value="1">Complete Payment</option>
                                                <option value="2">Cancel Transaction</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                            Update Status
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            <!-- History List View -->
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if(count($history) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 text-left">ID</th>
                                            <th class="py-3 px-4 text-left">Date</th>
                                            <th class="py-3 px-4 text-left">Total</th>
                                            <th class="py-3 px-4 text-left">Status</th>
                                            <th class="py-3 px-4 text-left">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($history as $item)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 px-4">{{ $item->id }}</td>
                                                <td class="py-3 px-4">{{ $item->created_at->format('d M Y, H:i') }}</td>
                                                <td class="py-3 px-4">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                                <td class="py-3 px-4">
                                                    @if($item->status == 0 || !isset($item->status))
                                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pending</span>
                                                    @elseif($item->status == 1)
                                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Completed</span>
                                                    @elseif($item->status == 2)
                                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4">
                                                    <a href="{{ route('history.show', $item->id) }}" class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600">
                                                        View Details
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500">No transaction history found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>