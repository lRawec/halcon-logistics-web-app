@extends('layouts.app', ['title' => 'Order Details'])

@section('content')
<div class="min-h-screen bg-gray-100">
    {{-- Header --}}
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900">
                        ← Back
                    </a>
                    <h1 class="text-2xl font-bold text-blue-600">Order #{{ $order->invoice_number }}</h1>
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
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Order Details --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Order Header Card --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Order Information</h2>
                        <span class="text-sm text-gray-500">Created: {{ \Illuminate\Support\Carbon::parse($order->created_at)->format('M d, Y') }}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Invoice & Status --}}
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <p class="text-sm text-gray-600 mb-1">Invoice Number</p>
                            <p class="text-2xl font-bold text-blue-600">#{{ $order->invoice_number }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Current Status</p>
                            @php
                                $statusColors = [
                                    'Ordered' => 'bg-yellow-100 text-yellow-800',
                                    'InProcess' => 'bg-blue-100 text-blue-800',
                                    'InRoute' => 'bg-indigo-100 text-indigo-800',
                                    'Delivered' => 'bg-green-100 text-green-800',
                                ];
                                $statusIcons = [
                                    'Ordered' => '📋',
                                    'InProcess' => '⚙️',
                                    'InRoute' => '🚚',
                                    'Delivered' => '✅',
                                ];
                                $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                $icon = $statusIcons[$order->status] ?? '❓';
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="text-2xl">{{ $icon }}</span>
                                <span class="inline-block px-4 py-1 text-sm font-bold rounded-full {{ $colorClass }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Order Date & Time --}}
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Order Date</p>
                                <p class="font-semibold text-gray-900">{{ \Illuminate\Support\Carbon::parse($order->order_date_time)->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Order Time</p>
                                <p class="font-semibold text-gray-900">{{ \Illuminate\Support\Carbon::parse($order->order_date_time)->format('H:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Created By</p>
                                <p class="font-semibold text-gray-900">{{ $order->user->username ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Customer Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Customer Name</p>
                            <p class="font-semibold text-gray-900">{{ $order->customer->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Customer Number</p>
                            <p class="font-semibold text-gray-900">{{ $order->customer_number }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-600 mb-1">Delivery Address</p>
                            <p class="text-gray-900 bg-gray-50 p-3 rounded">
                                {{ $order->delivery_address ?? 'N/A' }}
                            </p>
                        </div>
                        @if($order->customer->fiscal_data)
                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-600 mb-1">Fiscal Data</p>
                                <p class="text-gray-900 bg-gray-50 p-3 rounded">
                                    {{ $order->customer->fiscal_data }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Order Notes --}}
                @if($order->notes)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Notes</h3>
                        <p class="text-gray-700 bg-gray-50 p-4 rounded">{{ $order->notes }}</p>
                    </div>
                @endif

                {{-- Photo Evidence Section --}}
                @php
                    $loadedPhotos = $order->photoEvidences->where('type', 'Loaded');
                    $deliveredPhotos = $order->photoEvidences->where('type', 'Delivered');
                @endphp
                
                @if(($order->status === 'InRoute' || $order->status === 'Delivered') && $loadedPhotos->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Loaded Unit Photos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($loadedPhotos as $photo)
                                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                                    <div class="bg-amber-600 text-white px-4 py-2 font-semibold">
                                        Loading Photo
                                    </div>
                                    <div class="p-4">
                                        <img src="/{{ $photo->file_path }}" alt="Loaded Unit" 
                                            class="w-full h-64 object-cover rounded-lg">
                                        <p class="text-xs text-gray-600 mt-2">
                                            Uploaded: {{ \Illuminate\Support\Carbon::parse($photo->upload_date)->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($order->status === 'Delivered' && $deliveredPhotos->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Delivery Confirmation Photos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($deliveredPhotos as $photo)
                                <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                                    <div class="bg-green-600 text-white px-4 py-2 font-semibold">
                                        Delivery Photo
                                    </div>
                                    <div class="p-4">
                                        <img src="/{{ $photo->file_path }}" alt="Delivery" 
                                            class="w-full h-64 object-cover rounded-lg">
                                        <p class="text-xs text-gray-600 mt-2">
                                            Uploaded: {{ \Illuminate\Support\Carbon::parse($photo->upload_date)->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column: Status Update & Photos (Role-Based) --}}
            <div class="space-y-6">
                {{-- Status Update Form --}}
                @php
                    $userRole = strtolower(Auth::user()->role);
                    $canUpdateStatus = false;
                    $allowedStatuses = [];
                    
                    if ($userRole === 'admin') {
                        $canUpdateStatus = true;
                        $allowedStatuses = ['Ordered', 'InProcess', 'InRoute', 'Delivered'];
                    } elseif ($userRole === 'warehouse') {
                        $canUpdateStatus = true;
                        $allowedStatuses = ['InProcess', 'InRoute'];
                    } elseif ($userRole === 'route') {
                        $canUpdateStatus = $order->status === 'InRoute';
                        $allowedStatuses = $canUpdateStatus ? ['Delivered'] : [];
                    } elseif ($userRole === 'sales') {
                        $canUpdateStatus = true;
                        $allowedStatuses = ['Ordered', 'InProcess'];
                    }
                @endphp

                @if($canUpdateStatus)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Update Order</h3>
                        
                        <form method="POST" action="{{ route('orders.update', $order->order_id) }}" 
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')

                            {{-- Status Dropdown --}}
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Change Status
                                </label>
                                <select id="status" name="status"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                                    <option value="">-- Keep Current Status --</option>
                                    @foreach($allowedStatuses as $status)
                                        <option value="{{ $status }}" @if($status === $order->status) selected @endif>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-600 mt-1">
                                    Current: <strong>{{ $order->status }}</strong>
                                </p>
                            </div>

                            {{-- Photo Upload for Route Role --}}
                            @if($userRole === 'route' || $userRole === 'admin')
                                <div class="pt-4 border-t border-gray-200">
                                    <h4 class="font-semibold text-gray-900 mb-3">Photo Evidence</h4>
                                    
                                    {{-- Loading Photo (In Route) --}}
                                    @if($order->status === 'InRoute' || $userRole === 'admin')
                                        <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                            <label for="photo_in_route" class="block text-sm font-semibold text-gray-700 mb-2">
                                                Loading Photo (In Route)
                                            </label>
                                            <input type="file" id="photo_in_route" name="photo_in_route" 
                                                accept="image/*" capture="environment"
                                                class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                                            <p class="text-xs text-gray-600 mt-1">Upload when status is "In Route"</p>
                                        </div>
                                    @endif

                                    {{-- Delivery Photo (Delivered) --}}
                                    @if($order->status === 'Delivered' || $userRole === 'admin')
                                        <div class="p-3 bg-green-50 rounded-lg border border-green-200">
                                            <label for="photo_delivered" class="block text-sm font-semibold text-gray-700 mb-2">
                                                Delivery Photo (Delivered)
                                            </label>
                                            <input type="file" id="photo_delivered" name="photo_delivered" 
                                                accept="image/*" capture="environment"
                                                class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition">
                                            <p class="text-xs text-gray-600 mt-1">Upload when status is "Delivered"</p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Submit Button --}}
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                Update Order
                            </button>
                        </form>

                        {{-- Info Message --}}
                        <div class="mt-4 p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded text-sm text-yellow-700">
                            <strong>Your Role:</strong> {{ Auth::user()->role }}
                        </div>
                    </div>
                @else
                    {{-- Read-only for users without permissions --}}
                    <div class="bg-gray-50 rounded-lg shadow-md p-6 border-l-4 border-gray-400">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Status</h3>
                        <p class="text-gray-600 mb-4">
                            You don't have permission to update this order in its current state.
                        </p>
                        <div class="p-3 bg-white rounded border border-gray-200">
                            <p class="text-sm text-gray-600">Your Role</p>
                            <p class="font-semibold text-gray-900">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                @endif

                {{-- Quick Actions --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('orders.index') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                            Back to Orders
                        </a>
                        <a href="{{ route('orders.edit', $order->order_id) }}"
                            class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg text-center transition">
                            Edit Details
                        </a>
                        @if(Auth::user()->role === 'Admin' || Auth::user()->role === 'Sales')
                            <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" class="w-full"
                                onsubmit="return confirm('Archive this order?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                    Archive Order
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection