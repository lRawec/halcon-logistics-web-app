@extends('layouts.app', ['title' => 'Access Denied'])

@section('content')
<div class="min-h-screen bg-gradient-to-b from-red-50 to-white flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center">
        <div class="bg-white rounded-lg shadow-2xl p-12">
            <h1 class="text-5xl font-bold text-red-600 mb-2">403</h1>

            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                Access Denied
            </h2>

            <p class="text-gray-600 mb-8 leading-relaxed">
                You don't have permission to access this resource. 
                <span class="block text-sm text-gray-500 mt-2">
                    Your current role doesn't grant access to this area.
                </span>
            </p>

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded mb-8 text-left">
                <p class="text-sm text-blue-700">
                    <span class="font-semibold">Your Role:</span>
                    <span class="inline-block bg-blue-600 text-white px-3 py-1 rounded-full text-xs ml-2 font-bold">
                        {{ Auth::user()->role ?? 'Unknown' }}
                    </span>
                </p>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('dashboard') }}"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 active:scale-95">
                    Back to Dashboard
                </a>
                <a href="{{ route('home') }}"
                    class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Go to Home
                </a>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-xs text-gray-500">
                    If you believe this is a mistake, please 
                    <a href="mailto:support@halcon.com" class="text-blue-600 hover:text-blue-700 font-semibold">
                        contact support
                    </a>
                </p>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-500 text-sm">
                Halcon Logistics — Secure Access Control
            </p>
        </div>
    </div>
</div>
@endsection
