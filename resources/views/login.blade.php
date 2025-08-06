@extends('layout.main')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-200">
    <div class="max-w-md w-full bg-blue-200 p-8 rounded-2xl shadow-lg">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                Welcome To The Factory
            </h2>
            <p class="text-base text-gray-600">
                Login terlebih dahulu sebelum mengakses website pabrik
            </p>
        </div>

        <div class="bg-blue-50 rounded-xl p-6 mb-6">
            @if(session('gagal'))
            <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
             <div class="flex items-center space-x-2 text-sm text-red-600 mb-1">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ session('gagal') }}</span>
                        </div>
            </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    @foreach($errors->all() as $error)
                        <div class="flex items-center space-x-2 text-sm text-red-600 mb-1">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

           <center><h3 class="text-lg font-semibold text-blue-900 mb-4">USER LOGIN</h3></center>
            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="space-y-4">
                    <div class="relative">
                        <input type="email" name="email" id="email" required
                            class="peer w-full px-4 py-2.5 rounded-lg bg-white border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-900 placeholder-transparent"
                            placeholder=" ">
                        <label for="email"
                            class="absolute left-2 -top-2.5 bg-white px-2 text-sm text-gray-600
                                   transition-all duration-200
                                   peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                                   peer-placeholder-shown:top-2.5 peer-focus:-top-2.5
                                   peer-focus:text-sm peer-focus:text-blue-500">
                            Email
                        </label>
                    </div>

                    <div class="relative">
                        <input type="password" name="password" id="password" required
                            class="peer w-full px-4 py-2.5 rounded-lg bg-white border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-900 placeholder-transparent"
                            placeholder=" ">
                        <label for="password"
                            class="absolute left-2 -top-2.5 bg-white px-2 text-sm text-gray-600
                                   transition-all duration-200
                                   peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400
                                   peer-placeholder-shown:top-2.5 peer-focus:-top-2.5
                                   peer-focus:text-sm peer-focus:text-blue-500">
                            Password
                        </label>
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" id="eye-icon">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full bg-blue-500 text-white py-2.5 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <span class="btn-text">LOGIN</span>
                        <span class="loading hidden">
                            <svg class="animate-spin inline-block h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const eyeIcon = document.getElementById("eye-icon");

    if (password.type === "password") {
        password.type = "text";
        eyeIcon.innerHTML = `
            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>
        `;
    } else {
        password.type = "password";
        eyeIcon.innerHTML = `
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
        `;
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = submitBtn.querySelector('.loading');
    const btnText = submitBtn.querySelector('.btn-text');

    if (!email || !password) {
        e.preventDefault();
        alert('Please fill in all fields');
        return;
    }

    loadingSpinner.classList.remove('hidden');
    btnText.textContent = 'Signing in...';
    submitBtn.disabled = true;
});
</script>
@endsection
