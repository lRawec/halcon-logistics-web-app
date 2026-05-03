@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-md border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-blue-600">Halcon Logistics</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 font-medium">
                        Welcome, <strong>{{ Auth::user()->username }}</strong>
                    </span>
                    <span
                        class="inline-block px-3 py-1 text-sm font-bold rounded-full text-white
                        @if(strtolower(Auth::user()->role) === 'admin') bg-red-600
                        @elseif(strtolower(Auth::user()->role) === 'sales') bg-blue-600
                        @elseif(strtolower(Auth::user()->role) === 'warehouse') bg-green-600
                        @elseif(strtolower(Auth::user()->role) === 'route') bg-purple-600
                        @else bg-gray-600
                        @endif">
                        {{ Auth::user()->role }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="text-gray-600 hover:text-red-600 font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">Dashboard</h2>
            <p class="text-gray-600">
                {{ now()->format('l, F j, Y') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Orders</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalOrders }}</p>
                    </div>
                    <div class="text-5xl text-blue-500 opacity-20"></div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Active Orders</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $activeOrders }}</p>
                    </div>
                    <div class="text-5xl text-green-500 opacity-20"></div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Delivered</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $deliveredOrders }}</p>
                    </div>
                    <div class="text-5xl text-purple-500 opacity-20"></div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Archived</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $trashedOrders }}</p>
                    </div>
                    <div class="text-5xl text-red-500 opacity-20"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('orders.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                View All Orders
            </a>
            @if(auth()->user()->role === 'Sales' || auth()->user()->role === 'Admin')
                <a href="{{ route('orders.create') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                    Create Order
                </a>
                <a href="{{ route('customers.index') }}"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                    Manage Customers
                </a>
            @endif
            <a href="{{ route('orders.archived') }}"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                View Archived
            </a>
            @if(auth()->user()->role === 'Admin')
                <a href="{{ route('users.index') }}"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                    Manage Users
                </a>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Recent Orders</h3>
            </div>

            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Invoice</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created By</th>
                                <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-blue-600">
                                        #{{ $order->invoice_number }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $order->customer->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ \Illuminate\Support\Carbon::parse($order->order_date_time)->format('M d, Y') }}
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
                                        {{ $order->user->username ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('orders.show', $order->order_id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-8 text-center text-gray-500">
                    <p>No orders found. Start by creating a new order.</p>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection