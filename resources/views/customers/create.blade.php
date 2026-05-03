@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 max-w-2xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New Customer</h1>
        <p class="text-gray-600">Add a new customer to your system</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="customer_number" class="block text-sm font-semibold text-gray-700 mb-2">
                    Customer Number <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    id="customer_number" 
                    name="customer_number" 
                    value="{{ old('customer_number') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('customer_number') border-red-500 @enderror"
                    placeholder="e.g., 10001"
                    required
                >
                @error('customer_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Customer Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                    placeholder="Enter customer name"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="fiscal_data" class="block text-sm font-semibold text-gray-700 mb-2">
                    Fiscal Data <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="fiscal_data" 
                    name="fiscal_data" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fiscal_data') border-red-500 @enderror"
                    placeholder="Enter fiscal data (tax ID, business registration, etc.)"
                    required
                >{{ old('fiscal_data') }}</textarea>
                @error('fiscal_data')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-2">
                    Delivery Address <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="delivery_address" 
                    name="delivery_address" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('delivery_address') border-red-500 @enderror"
                    placeholder="Enter complete delivery address"
                    required
                >{{ old('delivery_address') }}</textarea>
                @error('delivery_address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-200">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition"
                >
                    Create Customer
                </button>
                <a 
                    href="{{ route('customers.index') }}" 
                    class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg text-center transition"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
