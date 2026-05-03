@extends('layouts.app', ['title' => 'Edit Order'])

@section('content')
<div class="min-h-screen bg-gray-100">
    {{-- Header --}}
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('orders.show', $order->order_id) }}" class="text-gray-600 hover:text-gray-900">
                        ← Back
                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">Edit Order #{{ $order->invoice_number }}</h1>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Form Card --}}
        <div class="bg-white rounded-lg shadow-md p-8">
            <form method="POST" action="{{ route('orders.update', $order->order_id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Current Status --}}
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-sm text-blue-600 mb-1">Current Status</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $order->status }}</p>
                </div>

                {{-- Delivery Address --}}
                <div>
                    <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-2">
                        Delivery Address
                    </label>
                    <textarea id="delivery_address" name="delivery_address" rows="4"
                        placeholder="Enter the full delivery address"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('delivery_address') border-red-500 @enderror">{{ old('delivery_address', $order->delivery_address) }}</textarea>
                    @error('delivery_address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                        Notes
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                        placeholder="Any additional information about this order"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">{{ old('notes', $order->notes) }}</textarea>
                </div>

                {{-- Order Details (Read-only) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Invoice Number</p>
                        <p class="font-semibold text-gray-900">#{{ $order->invoice_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Customer</p>
                        <p class="font-semibold text-gray-900">{{ $order->customer->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Order Date</p>
                        <p class="font-semibold text-gray-900">{{ \Illuminate\Support\Carbon::parse($order->order_date_time)->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Created By</p>
                        <p class="font-semibold text-gray-900">{{ $order->user->username ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 active:scale-95">
                        Save Changes
                    </button>
                    <a href="{{ route('orders.show', $order->order_id) }}"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
