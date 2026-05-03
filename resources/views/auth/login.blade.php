@extends('layouts.app', ['title' => 'Employee Login'])

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-2xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Halcon Logistics</h1>
                <p class="text-gray-600">Employee Portal</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-red-700 font-semibold text-sm">
                        {{ $errors->first() }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                        Username
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        required autofocus
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('username') border-red-500 @enderror"
                        placeholder="Enter your username">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                        placeholder="Enter your password">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-105 active:scale-95 mt-6">
                    Sign In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    Only authorized employees can access this portal
                </p>
                <p class="text-center text-xs text-gray-500 mt-2">
                    For access requests, contact your administrator
                </p>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}"
                    class="text-blue-600 hover:text-blue-700 text-sm font-medium transition">
                    Back to Order Tracking
                </a>
            </div>
        </div>

        <div class="mt-8 text-center text-white text-sm">
            <p>© {{ date('Y') }} Halcon Logistics. All rights reserved.</p>
        </div>
    </div>
</div>
@endsection