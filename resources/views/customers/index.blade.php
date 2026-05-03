@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Customer Management</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Add New Customer
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer #</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Fiscal Data</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Delivery Address</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-bold text-blue-600">{{ $customer->customer_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $customer->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <span class="truncate inline-block max-w-xs">{{ Str::limit($customer->fiscal_data, 40) }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <span class="truncate inline-block max-w-xs">{{ Str::limit($customer->delivery_address, 40) }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ \Illuminate\Support\Carbon::parse($customer->created_at)->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <p>No customers found. Create one to get started!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">← Back to Dashboard</a>
    </div>
</div>
@endsection
