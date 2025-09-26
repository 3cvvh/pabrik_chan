@extends('layout.main')
@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Forgot Password</h2>
    @if (session('status'))
        <div class="mb-4 text-green-600">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block mb-1">Email</label>
            <input id="email" type="email" name="email" required class="w-full border rounded px-3 py-2">
            @error('email')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Send Reset Link</button>
    </form>
    <br>
    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded">kembali</a>
</div>
@endsection
