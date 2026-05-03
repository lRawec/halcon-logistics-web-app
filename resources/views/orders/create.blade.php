@extends('layouts.app', ['title' => 'Create Order'])

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900">
                        ← Back
                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">Create New Order</h1>
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

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-md p-8">
            <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="invoice_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Invoice Number *
                    </label>
                    <input type="number" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}"
                        placeholder="e.g., 1001" required
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('invoice_number') border-red-500 @enderror">
                    @error('invoice_number')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="customer_number" class="block text-sm font-semibold text-gray-700 mb-2">
                        Customer *
                    </label>
                    <select id="customer_number" name="customer_number" required
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('customer_number') border-red-500 @enderror">
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->customer_number }}" 
                                data-delivery="{{ e($customer->delivery_address) }}"
                                data-fiscal="{{ e($customer->fiscal_data) }}"
                                @if(old('customer_number') == $customer->customer_number) selected @endif>
                                {{ $customer->name }} ({{ $customer->customer_number }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_number')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Delivery Address *
                        </label>
                        <textarea id="delivery_address" name="delivery_address" rows="4" required
                            placeholder="Enter the full delivery address"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('delivery_address') border-red-500 @enderror">{{ old('delivery_address') }}</textarea>
                        @error('delivery_address')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fiscal_data" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fiscal / Tax Data
                        </label>
                        <textarea id="fiscal_data" name="fiscal_data" rows="4"
                            placeholder="Tax ID, VAT, or other fiscal information"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">{{ old('fiscal_data') }}</textarea>
                    </div>
                </div>

                <div>
                    <label for="order_date_time" class="block text-sm font-semibold text-gray-700 mb-2">
                        Order Date & Time *
                    </label>
                    <input type="datetime-local" id="order_date_time" name="order_date_time" 
                        value="{{ old('order_date_time', now()->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('order_date_time') border-red-500 @enderror">
                    @error('order_date_time')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                        Additional Notes
                    </label>
                    <textarea id="notes" name="notes" rows="4"
                        placeholder="Any additional information about this order"
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">{{ old('notes') }}</textarea>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                    <p class="text-blue-700 text-sm">
                        <strong>Note:</strong> The order will be created with status "Ordered". It will progress through the workflow as it is processed by the warehouse and delivery teams.
                    </p>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 active:scale-95">
                        Create Order
                    </button>
                    <a href="{{ route('orders.index') }}"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection

@push('extra_scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var sel = document.getElementById('customer_number');
    var delivery = document.getElementById('delivery_address');
    var fiscal = document.getElementById('fiscal_data');

    if (!sel) return;

    function populate() {
        var opt = sel.options[sel.selectedIndex];
        if (!opt) return;
        // Use dataset values (already HTML-escaped)
        delivery.value = opt.dataset.delivery || '';
        fiscal.value = opt.dataset.fiscal || '';
    }

    sel.addEventListener('change', populate);

    // If a customer is already selected (old input), populate on load
    if (sel.value) {
        populate();
    }
});
</script>
@endpush