@if(session()->has('berhasil'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('berhasil') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif
@if(session()->has('gagal'))
    Swal.fire({
        icon: 'error',
        title: 'gagal!',
        text: '{{ session('gagal') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif
@if(session()->has('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'gagal!',
        text: '{{ session('warning') }}',
        timer: 1500,
        showConfirmButton: false
    });
@endif

