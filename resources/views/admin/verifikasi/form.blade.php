@extends('layout.main')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="border-b border-gray-200 px-6 py-4">
            <h4 class="text-xl font-semibold text-gray-800">Penerimaan Pegawai</h4>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <p class="text-gray-600">Email Kandidat: <span class="font-medium text-gray-900">{{ $user->email }}</span></p>
            </div>

            <form action="" method="post">
                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role:</label>
                    <select name="role" id="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach ($role as $index => $item)
                        <option value="{{ $item->id }}" {{ old('role', '') == $item->id ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status:</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="approve">Terima</option>
                        <option value="reject">Tolak</option>
                    </select>
                    @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Confirm
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
