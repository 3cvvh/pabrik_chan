@extends('layout.main')
@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="max-w-lg w-full bg-white rounded-lg shadow-xl p-8 transform transition-all duration-500 opacity-0" id="successCard">
        <div class="text-center">
            <div class="inline-block p-4 bg-green-50 rounded-full mb-4">
                <svg class="w-16 h-16 text-green-500 check-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Pembayaran Berhasil!</h1>
            <p class="text-gray-600 mb-8">Terima kasih atas pembelian Anda. Pesanan Anda akan segera diproses.</p>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order ID</span>
                    <span class="font-semibold">{{ $order_id ?? '#ORD123456' }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Total Pembayaran</span>
                    <span class="font-semibold">{{ $total ?? 'Rp 500.000' }}</span>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('admin.index') }}" class="bg-green-500 hover:bg-green-600 text-black font-semibold px-6 py-3 rounded-lg transition-colors duration-300">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const card = document.getElementById('successCard');
    const checkIcon = document.querySelector('.check-icon');

    // Animate card appearance
    setTimeout(() => {
        card.classList.remove('opacity-0');
        card.classList.add('opacity-100', 'translate-y-0');
    }, 100);

    // Animate check icon
    checkIcon.style.strokeDasharray = '100';
    checkIcon.style.strokeDashoffset = '100';
    checkIcon.style.animation = 'drawCheck 1s ease-in-out forwards';
});
</script>

<style>
@keyframes drawCheck {
    from {
        stroke-dashoffset: 100;
    }
    to {
        stroke-dashoffset: 0;
    }
}
</style>
@endsection
