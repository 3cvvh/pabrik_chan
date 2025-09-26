@if(session()->has('berhasil'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('berhasil') }}',
        timer: 15000,
        showConfirmButton: false
    });
    @if(session('berhasil') == true)
        setTimeout(function() {
            location.reload();
        }, 1000);
    @endif
@endif
@if(session()->has('gagal'))
    Swal.fire({
        icon: 'error',
        title: 'gagal!',
        text: '{{ session('gagal') }}',
        timer: 15000,
        showConfirmButton: false
    });
    @if(session('gagal') == true)
        setTimeout(function() {
            location.reload();
        }, 1000);
    @endif
@endif
@if(session()->has('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'gagal!',
        text: '{{ session('warning') }}',
        timer: 15000,
        showConfirmButton: false
    });
    @if(session('warning') == true)
        setTimeout(function() {
            location.reload();
        }, 1000);
        @endif
@endif

