@extends('layouts.app', ['title' => 'Order Tracking'])

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white">
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">Halcon Logistics</h1>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-blue-600 font-medium transition">Employee Access</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Track Your Order
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Enter your customer number and invoice number to check your delivery status and view evidence photos.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8 md:p-10 mb-12">
            <form method="GET" action="{{ route('home') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="customer_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Customer Number *
                        </label>
                        <input type="text" id="customer_number" name="customer_number"
                            value="{{ old('customer_number', request('customer_number')) }}"
                            placeholder="e.g., CUST-001" required autofocus
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    </div>

                    <div>
                        <label for="invoice_number" class="block text-sm font-semibold text-gray-700 mb-2">
                            Invoice Number *
                        </label>
                        <input type="text" id="invoice_number" name="invoice_number"
                            value="{{ old('invoice_number', request('invoice_number')) }}"
                            placeholder="e.g., 1002" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 active:scale-95">
                    Search Order
                </button>
            </form>
        </div>

        @if(isset($order))
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Order Details</h3>
                        <span class="text-sm text-gray-500">Invoice #{{ $order->invoice_number }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <p class="text-sm text-gray-500 mb-1">Customer</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ $order->customer->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ $order->customer->customer_number ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-purple-500">
                            <p class="text-sm text-gray-500 mb-1">Order Date</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($order->order_date_time)->format('M d, Y') }}
                            </p>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ \Carbon\Carbon::parse($order->order_date_time)->format('H:i A') }}
                            </p>
                        </div>
                    </div>

                    {{-- Status Badge --}}
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-3">Current Status</p>
                        <div class="flex items-center space-x-3">
                            @php
                                $statusColors = [
                                    'Ordered' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                                    'In process' => 'bg-blue-100 text-blue-800 border-blue-300',
                                    'In route' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                    'Delivered' => 'bg-green-100 text-green-800 border-green-300',
                                ];
                                $statusIcons = [
                                    'Ordered' => '',
                                    'In process' => '',
                                    'In route' => '',
                                    'Delivered' => '',
                                ];
                                $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800 border-gray-300';
                                $icon = $statusIcons[$order->status] ?? '';
                            @endphp
                            <span class="text-2xl">{{ $icon }}</span>
                            <span
                                class="inline-block px-6 py-3 font-bold rounded-lg border-2 text-lg {{ $colorClass }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    @if($order->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-2">Notes</p>
                            <p class="text-gray-700 bg-gray-50 p-3 rounded-lg">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

                @php
                    $loadedPhotos = $order->photoEvidences->where('type', 'Loaded');
                    $deliveredPhotos = $order->photoEvidences->where('type', 'Delivered');
                @endphp
                
                @if($loadedPhotos->count() > 0 || $deliveredPhotos->count() > 0)
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        @if(($order->status === 'InRoute' || $order->status === 'Delivered') && $loadedPhotos->count() > 0)
                            <div class="mb-8">
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Loaded Unit Photos</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($loadedPhotos as $photo)
                                        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md">
                                            <div class="bg-amber-600 text-white px-4 py-2 font-semibold">
                                                Loading Photo
                                            </div>
                                            <div class="p-4">
                                                <img src="/storage/{{ str_replace('storage/', '', $photo->file_path) }}"
                                                    alt="Loaded Unit" class="w-full h-auto rounded-lg object-cover">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($order->status === 'Delivered' && $deliveredPhotos->count() > 0)
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-4">Delivery Confirmation Photos</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($deliveredPhotos as $photo)
                                        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md">
                                            <div class="bg-green-600 text-white px-4 py-2 font-semibold">
                                                Delivery Photo
                                            </div>
                                            <div class="p-4">
                                                <img src="/storage/{{ str_replace('storage/', '', $photo->file_path) }}"
                                                    alt="Delivery" class="w-full h-auto rounded-lg object-cover">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($order->status === 'InRoute')
                    <div class="bg-amber-50 border-2 border-amber-200 rounded-lg p-6 text-center">
                        <p class="text-amber-700 font-medium">
                            Loading unit photos will appear here once the truck is en route.
                        </p>
                    </div>
                @elseif($order->status !== 'Delivered')
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 text-center">
                        <p class="text-blue-700 font-medium">
                            Evidence photos will appear here as your order progresses.
                        </p>
                    </div>
                @endif

                {{-- New Search Button --}}
                <div class="flex gap-4">
                    <a href="{{ route('home') }}"
                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-200">
                        New Search
                    </a>
                </div>
            </div>
        @elseif(request()->has('customer_number') && request()->has('invoice_number'))
            {{-- Not Found Message --}}
            <div class="bg-red-50 border-2 border-red-300 rounded-lg p-8 text-center">
                <div class="text-5xl mb-4">❌</div>
                <h3 class="text-2xl font-bold text-red-800 mb-2">Order Not Found</h3>
                <p class="text-red-700 mb-6">
                    We couldn't find an order with customer number
                    <strong>{{ request('customer_number') }}</strong> and invoice number
                    <strong>{{ request('invoice_number') }}</strong>.
                </p>
                <p class="text-red-600 mb-6">Please double-check your information and try again.</p>
                <a href="{{ route('home') }}"
                    class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                    Try Again
                </a>
            </div>
        @endif
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="text-white font-bold mb-4">Halcon Logistics</h5>
                    <p class="text-sm">Your trusted partner for construction material distribution.</p>
                </div>
                <div>
                    <h5 class="text-white font-bold mb-4">Support</h5>
                    <p class="text-sm">Need help? <a href="mailto:support@halcon.com" class="text-blue-400 hover:text-blue-300">Contact us</a></p>
                </div>
                <div>
                    <h5 class="text-white font-bold mb-4">Employee Access</h5>
                    <p class="text-sm"><a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300">Internal Portal</a></p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Halcon Logistics. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

@php
    $showNotFoundError = request()->has('customer_number') && request()->has('invoice_number') && !isset($order);
    $customerNum = request('customer_number');
    $invoiceNum = request('invoice_number');
@endphp

{{-- Order Not Found Notification --}}
@if ($showNotFoundError)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toastr.error(
                'We couldn\'t find an order with customer number {{ addslashes($customerNum) }} and invoice number {{ addslashes($invoiceNum) }}. Please double-check your information.',
                'Order Not Found',
                { closeButton: true, tapToDismiss: false, timeOut: 8000 }
            );
        });
    </script>
@endif
@endsection