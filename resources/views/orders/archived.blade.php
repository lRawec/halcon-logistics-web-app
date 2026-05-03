@extends('layouts.app', ['title' => 'Archived Orders'])

@section('content')
<div class="min-h-screen bg-gray-100">
    {{-- Header --}}
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                        ← Back
                    </a>
                    <h1 class="text-2xl font-bold text-red-600">Archived Orders</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View Active Orders
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Info Message --}}
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg mb-8">
            <p class="text-yellow-700 font-medium">
                Archived orders are soft-deleted. You can restore them to return them to active status.
            </p>
        </div>

        {{-- Search & Filter Section --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Search Archived</h3>
            
            <form action="{{ route('orders.archived') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Invoice Number --}}
                    <div>
                        <label for="invoice" class="block text-sm font-semibold text-gray-700 mb-2">
                            Invoice Number
                        </label>
                        <input type="text" id="invoice" name="invoice" value="{{ request('invoice') }}"
                            placeholder="Enter invoice #"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    </div>

                    {{-- Customer Number --}}
                    <div>
                        <label for="customer" class="block text-sm font-semibold text-gray-700 mb-2">
                            Customer Number
                        </label>
                        <input type="text" id="customer" name="customer" value="{{ request('customer') }}"
                            placeholder="Enter customer #"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            Search
                        </button>
                        <a href="{{ route('orders.archived') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Archived Orders Table --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">
                    Total: {{ $orders->total() }} Archived Orders
                </h3>
            </div>

            @if($orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Invoice</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Archived Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Original Date</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-blue-600">
                                        #{{ $order->invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        <div class="font-semibold">{{ $order->customer->name ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-600">{{ $order->customer_number }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'Ordered' => 'bg-yellow-100 text-yellow-800',
                                                'InProcess' => 'bg-blue-100 text-blue-800',
                                                'InRoute' => 'bg-indigo-100 text-indigo-800',
                                                'Delivered' => 'bg-green-100 text-green-800',
                                            ];
                                            $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-block px-3 py-1 text-xs font-bold rounded-full {{ $colorClass }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ \Illuminate\Support\Carbon::parse($order->deleted_at)->format('M d, Y - H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ \Illuminate\Support\Carbon::parse($order->order_date_time)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('orders.show', $order->order_id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                                View
                                            </a>
                                            <form action="{{ route('orders.restore', $order->order_id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-800 font-semibold text-sm"
                                                    onclick="return confirm('Restore this order?');">
                                                    Restore
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="px-6 py-8 text-center text-gray-500">
                    <p class="text-lg">No archived orders found!</p>
                    <p class="text-sm">All your orders are active and running smoothly.</p>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection