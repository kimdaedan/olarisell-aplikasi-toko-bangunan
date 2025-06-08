@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Login ke Aplikasi Kasir</h2>

    <form action="{{ route('login') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" name="username" id="username" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md
                          focus:outline-none focus:ring focus:ring-blue-500">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Login</button>
        </div>
    </form>
</div>
@endsection