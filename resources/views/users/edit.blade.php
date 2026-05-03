@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        
        <div class="bg-gray-800 px-6 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-Black">Edit User: {{ $user->username }}</h2>
            <a href="{{ route('users.index') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition">← Back to Users List</a>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-bold mb-2">Username *</label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('username') border-red-500 @enderror" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-bold mb-2">
                    Password <span class="text-sm font-normal text-gray-500">(Leave blank to keep current)</span>
                </label>
                <input type="password" name="password" id="password" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="role" class="block text-gray-700 font-bold mb-2">Department (Role) *</label>
                <select name="role" id="role" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="admin" {{ strtolower($user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="sales" {{ strtolower($user->role) == 'sales' ? 'selected' : '' }}>Sales</option>
                    <option value="purchasing" {{ strtolower($user->role) == 'purchasing' ? 'selected' : '' }}>Purchasing</option>
                    <option value="warehouse" {{ strtolower($user->role) == 'warehouse' ? 'selected' : '' }}>Warehouse</option>
                    <option value="route" {{ strtolower($user->role) == 'route' ? 'selected' : '' }}>Route</option>
                </select>
                @error('role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" 
                           class="form-checkbox h-5 w-5 text-blue-600 rounded" 
                           {{ $user->is_active ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700 font-bold">Active User</span>
                </label>
            </div>

            <div class="flex items-center justify-center space-x-4 mt-8 w-full">
                <a href="{{ route('users.index') }}" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition text-center inline-block">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition text-center inline-block">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection