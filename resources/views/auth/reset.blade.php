@extends('layout.main')
@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Reset Password</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-4">
            <label for="email" class="block mb-1">Email</label>
            <input readonly id="email" value="{{ $_GET["email"] }}" type="email" name="email" required class="w-full border rounded px-3 py-2">
            @error('email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-1">New Password</label>
            <input id="password" type="password" name="password" required class="w-full border rounded px-3 py-2">
            @error('password')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Reset Password</button>
    </form>
</div>
@endsection
