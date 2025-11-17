{{-- filepath: c:\laragon\www\pabrik_chan\resources\views\profile\index.blade.php --}}
@extends('layout.main')
@section('content')
@php
	$initial = strtoupper(substr(trim($data->name ?? ''), 0, 1));
	// simple SVG avatar with cyan background and white letter
	$svg = "<svg xmlns='http://www.w3.org/2000/svg' width='256' height='256' viewBox='0 0 256 256'><rect width='100%' height='100%' fill='#06b6d4'/><text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='Inter,Segoe UI,Roboto,Arial' font-size='120' fill='white'>$initial</text></svg>";
	$avatarData = 'data:image/svg+xml;utf8,' . rawurlencode($svg);
	$hasPhoto = !empty($data->profile_picture_path);
	$avatarSrc = $hasPhoto ? asset('storage/' . $data->profile_picture_path) : $avatarData;
	$editAvatarSrc = $avatarSrc;
@endphp
<div class="fixed inset-0 flex items-start sm:items-center justify-center min-h-screen overflow-auto sm:overflow-visible p-4 sm:p-0" style="background: linear-gradient(135deg, #e0f7fa 0%, #b2ebf2 100%);">
    <div class="relative z-10 w-full sm:w-[90vw] max-w-6xl mx-auto bg-white/90 shadow-2xl rounded-3xl overflow-visible border border-cyan-200 transition-all duration-300" style="box-shadow: 0 8px 40px 0 rgba(0,180,216,0.18);">
        <!-- Header -->
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
        <div class="bg-gradient-to-r from-cyan-400 via-cyan-300 to-blue-200 p-6 sm:p-12 rounded-t-3xl">
            <div class="flex items-center gap-4 sm:gap-10">
                <img id="profileAvatar" src="{{ $avatarSrc }}" alt="Avatar" class="w-20 h-20 sm:w-32 sm:h-32 rounded-full ring-4 ring-white object-cover shadow-lg border-2 border-cyan-200 transition-all duration-300 cursor-pointer" title="Click to view">
                <div class="text-cyan-900">
                    <h1 class="text-xl sm:text-3xl font-bold tracking-tight">{{ $data->name }}
                        <span class="ml-2 inline-block px-2 sm:px-3 py-1 text-xs sm:text-base bg-cyan-100/80 text-cyan-700 rounded-lg shadow-sm">{{ $data->role_id == null ? "no role" : $data->role->name }}</span>
                    </h1>
                    <p class="text-xs sm:text-sm opacity-80 mt-2">{{ $data->pabrik->name }}  {{ $data->role_id == 2 ? "·" . $data->gudang->nama : "" }} </p>
                </div>
                <div class="ml-auto flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button id="openEditBtn" class="inline-flex items-center px-3 sm:px-5 py-2 bg-cyan-100 text-cyan-700 rounded-lg text-sm sm:text-base font-medium shadow-sm border border-cyan-200 hover:bg-cyan-200 hover:text-cyan-900 transition-all duration-200 focus:ring-2 focus:ring-cyan-300">Edit</button>
                    <button id="openPasswordBtn" class="inline-flex items-center px-3 sm:px-5 py-2 border border-cyan-200 text-cyan-700 rounded-lg text-sm sm:text-base hover:bg-cyan-100 hover:text-cyan-900 transition-all duration-200 focus:ring-2 focus:ring-cyan-300">Change Pass</button>
                </div>
            </div>
        </div>
        <!-- Content -->
        <div class="p-6 sm:p-12 space-y-10 bg-cyan-50 rounded-b-3xl">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-10">
                <div class="sm:col-span-3 bg-white/95 p-12 rounded-3xl border border-cyan-100 shadow-2xl transition-all duration-300"
                     style="font-family: 'Inter', 'Segoe UI', 'Roboto', 'Arial', sans-serif;">
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-x-20 gap-y-10 text-lg sm:text-2xl text-gray-900 font-semibold">
                        <div>
                            <span class="text-cyan-700 font-bold text-lg sm:text-2xl md:text-3xl">Phone:</span>
                            <span class="ml-4 font-medium tracking-wide text-sm sm:text-base">{{ $data->phone ?? "Belum memasukkan No.Telp" }}</span>
                        </div>
                        <div>
                            <span class="text-cyan-700 font-bold text-lg sm:text-2xl md:text-3xl">Address:</span>
                            <span class="ml-4 font-medium tracking-wide text-sm sm:text-base">{{ $data->alamat ?? "Belum memasukkan Alamat" }}</span>
                        </div>
                        <div>
                            <span class="text-cyan-700 font-bold text-lg sm:text-2xl md:text-3xl">Email:</span>
                            <span class="ml-4 font-medium tracking-wide text-sm sm:text-base">{{ $data->email }}</span>
                        </div>
                         <div>
                            <span class="text-cyan-700 font-bold text-lg sm:text-2xl md:text-3xl">Pabrik:</span>
                            <span class="ml-4 font-medium tracking-wide text-sm sm:text-base">{{ $data->pabrik->name ?? "tidak mempunyai Pabrik" }}</span>
                        </div>
                        @if ($data->role_id == 2)
                        <div>
                            <span class="text-cyan-700 font-bold text-2xl md:text-3xl">Gudang:</span>
                            <span class="ml-4 font-medium tracking-wide">{{ $data->gudang->nama ?? 'tidak ada gudang' }}</span>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="flex flex-wrap gap-6">
                <form id="logoutForm" action="{{ route('logout') }}" method="post">
                     @csrf
                     <button class="px-4 sm:px-5 py-2 border border-cyan-200 bg-white text-cyan-700 rounded-lg text-sm sm:text-base hover:bg-cyan-100 hover:text-cyan-900 transition-all duration-200 focus:ring-2 focus:ring-cyan-300">Logout</button>
                 </form>
            </div>
        </div>
        <a onclick="window.history.back()" aria-label="Kembali"
            class="absolute bottom-4 right-4 sm:bottom-6 sm:right-6 inline-flex items-center gap-2 px-3 sm:px-4 py-2 bg-white/95 text-cyan-700 rounded-full shadow-lg border border-cyan-100 hover:bg-cyan-100 transition-all duration-150 z-20">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11l3.707-3.707a1 1 0 011.414 1.414L5.414 11l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
            <path d="M13 11a1 1 0 10-2 0v.001A1 1 0 0013 11z" />
        </svg>
        <span class=" sm:inline">Back</span>
    </button>
    </div>
</div>

<!-- Modal: Change Password -->
<div id="changePasswordModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <!-- overlay -->
    <div id="passwordModalOverlay" class="fixed inset-0 bg-cyan-900/30"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden border border-cyan-100 transition-all duration-300" style="z-index:9999;">
        <div class="p-4 sm:p-6 border-b border-cyan-100 flex items-center justify-between bg-cyan-50">
            <h2 class="text-xl font-semibold text-cyan-800">Change Password</h2>
            <button id="closePasswordBtn" class="text-cyan-400 hover:text-cyan-700 text-2xl leading-none">&times;</button>
        </div>

        <form action="{{ route('profile.changePassword',$data->id) }}" method="POST" class="p-8 space-y-5 bg-white">
            @csrf
            <div>
                <label class="block text-xs font-medium text-cyan-700">Current Password</label>
                <input type="password" name="current_password" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400" placeholder="Enter current password">
            </div>
            <div>
                <label class="block text-xs font-medium text-cyan-700">New Password</label>
                <input type="password" name="password" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400" placeholder="Enter new password">
            </div>
            <div>
                <label class="block text-xs font-medium text-cyan-700">Confirm Password</label>
                <input type="password" name="password_confirmation" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400" placeholder="Confirm new password">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="cancelPasswordBtn" class="px-4 py-2 bg-cyan-50 border border-cyan-100 rounded text-base text-cyan-700 hover:bg-cyan-100">Cancel</button>
                <button type="submit" id="savePasswordBtn" class="px-4 py-2 bg-cyan-400 text-white rounded text-base hover:bg-cyan-500">Update Password</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal: Edit Profile -->
<div id="editProfileModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <!-- overlay -->
    <div id="modalOverlay" class="fixed inset-0 bg-cyan-900/30"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden border border-cyan-100 transition-all duration-300" style="z-index:9999;">
        <div class="p-6 border-b border-cyan-100 flex items-center justify-between bg-cyan-50">
            <h2 class="text-xl font-semibold text-cyan-800">Edit Profile</h2>
            <button id="closeEditBtn" class="text-cyan-400 hover:text-cyan-700 text-2xl leading-none">&times;</button>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('user.update',$data->id) }}" id="editProfileForm" class="p-8 space-y-5 bg-white">
            @csrf
            @method('PUT')
            <div class="flex items-start gap-6">
                <!-- Avatar preview column: image on top, buttons below -->
                <div class="flex flex-col items-center gap-3">
                    <img id="editAvatarPreview" src="{{ $editAvatarSrc }}" alt="Avatar Preview" class="w-16 h-16 sm:w-24 sm:h-24 rounded-full object-cover ring-2 ring-cyan-200 border border-cyan-100 shadow cursor-pointer" title="Click to view">
                    <div class="flex flex-col items-center gap-2">
                        <input type="hidden" name="remove_avatar" id="removeAvatarInput" value="0">
                        <button type="button" id="removeAvatarBtn" class="px-3 py-1 text-xs bg-red-50 text-red-600 border border-red-100 rounded hover:bg-red-100">Remove photo</button>
                        <button type="button" id="undoRemoveAvatarBtn" class="px-3 py-1 text-xs bg-cyan-50 text-cyan-700 border border-cyan-100 rounded hidden">Undo</button>
                        <span id="willRemoveNote" class="text-xs text-red-600 hidden">Photo will be removed when you save.</span>
                    </div>
                </div>

                <!-- Upload input stays on the right -->
                <div>
                    <label class="block text-xs font-medium text-cyan-700">Upload Avatar</label>
                    <input name="gambar" id="avatarInput" type="file" class="mt-1 block text-base text-cyan-700">
                    <p class="text-xs text-cyan-400 mt-1">PNG/JPG, max 2MB (preview otomatis)</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-medium text-cyan-700">Name</label>
                    <input type="text" name="name" value="{{ $data->name }}" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-cyan-700">Email</label>
                    <input type="email" name="email" value="{{ $data->email }}" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-cyan-700">Phone</label>
                    <input type="text" name="phone" value="{{ $data->phone }}" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400">
                </div>
                <div>
                    <label class="block text-xs font-medium text-cyan-700">Address</label>
                    <input type="text" name="alamat" value="{{ $data->alamat }}" class="mt-1 block w-full border border-cyan-200 rounded px-3 py-2 text-base focus:ring-cyan-300 focus:border-cyan-400">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                <button type="button" id="cancelEditBtn" class="px-4 py-2 bg-cyan-50 border border-cyan-100 rounded text-base text-cyan-700 hover:bg-cyan-100">Cancel</button>
                <button type="submit" id="saveEditBtn" class="px-4 py-2 bg-cyan-400 text-white rounded text-base hover:bg-cyan-500">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Image Viewer -->
<div id="imageViewerModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div id="imageViewerOverlay" class="fixed inset-0 bg-black/60"></div>
    <div class="relative max-w-[90vw] max-h-[90vh] mx-4">
        <button id="imageViewerClose" class="absolute top-2 right-2 z-20 text-white text-2xl bg-black/30 rounded-full w-9 h-9 flex items-center justify-center">×</button>
        <img id="imageViewerImg" src="" alt="Preview" class="block max-w-full max-h-[90vh] mx-auto rounded-lg shadow-lg object-contain" />
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modal toggle script -->
<script>
    <x-alert></x-alert>
    (function(){
        const editModal = document.getElementById('editProfileModal');
        const openEditBtn = document.getElementById('openEditBtn');
        const closeEditBtn = document.getElementById('closeEditBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editOverlay = document.getElementById('modalOverlay');
        const saveEditBtn = document.getElementById('saveEditBtn');
        const profileAvatar = document.getElementById('profileAvatar');
        const avatarInput = document.getElementById('avatarInput');
        const editAvatarPreview = document.getElementById('editAvatarPreview');
        const removeAvatarInput = document.getElementById('removeAvatarInput');
        const removeAvatarBtn = document.getElementById('removeAvatarBtn');
        const undoRemoveAvatarBtn = document.getElementById('undoRemoveAvatarBtn');
        const willRemoveNote = document.getElementById('willRemoveNote');
        // store original src to allow undo
        const originalAvatarSrc = editAvatarPreview ? editAvatarPreview.src : (profileAvatar ? profileAvatar.src : '');
        const placeholderAvatar = 'https://placehold.co/256x256/avatar.png';
         let tempAvatarURL = null;

        function openEditModal(){
            // set modal preview to current avatar
            if(profileAvatar && editAvatarPreview){
                editAvatarPreview.src = profileAvatar.src || editAvatarPreview.src;
            }
            editModal.classList.remove('hidden');
            editModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        // new: fungsi untuk menutup modal edit dengan cleanup
        function closeEditModal(){
            if(!editModal) return;
            editModal.classList.add('hidden');
            editModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
            // revoke temporary object URL jika ada
            if(tempAvatarURL){
                try{ URL.revokeObjectURL(tempAvatarURL); } catch(e){}
                tempAvatarURL = null;
            }
        }

        openEditBtn && openEditBtn.addEventListener('click', openEditModal);
        closeEditBtn && closeEditBtn.addEventListener('click', closeEditModal);
        cancelEditBtn && cancelEditBtn.addEventListener('click', closeEditModal);
        editOverlay && editOverlay.addEventListener('click', closeEditModal);

        saveEditBtn && saveEditBtn.addEventListener('click', function(){
            // if user picked an avatar, update header avatar to preview (for UI only)
            if(avatarInput && avatarInput.files && avatarInput.files[0] && profileAvatar && editAvatarPreview){
                profileAvatar.src = editAvatarPreview.src;
            }
            // if remove flag set, show placeholder in header as well for instant feedback
            if(removeAvatarInput && removeAvatarInput.value === '1' && profileAvatar){
                profileAvatar.src = placeholderAvatar;
            }
            closeEditModal();
        });

        // Handle avatar file selection -> preview (also cancels remove flag)
        if(avatarInput && editAvatarPreview){
            avatarInput.addEventListener('change', function(e){
                const file = this.files && this.files[0];
                if(!file) return;
                if(!file.type.startsWith('image/')) return;
                if(tempAvatarURL) URL.revokeObjectURL(tempAvatarURL);
                tempAvatarURL = URL.createObjectURL(file);
                editAvatarPreview.src = tempAvatarURL;
                // if user selects a file, they clearly don't want to remove the avatar
                if(removeAvatarInput){
                    removeAvatarInput.value = '0';
                    undoRemoveAvatarBtn && (undoRemoveAvatarBtn.classList.add('hidden'));
                    willRemoveNote && (willRemoveNote.classList.add('hidden'));
                }
            });
        }

        // Remove avatar handler: set flag, swap preview to placeholder, show undo
        if(removeAvatarBtn){
            removeAvatarBtn.addEventListener('click', function(){
                if(!removeAvatarInput) return;
                removeAvatarInput.value = '1';
                // clear file input if any
                try{ avatarInput.value = ''; }catch(e){}
                // revoke temp url if exists
                if(tempAvatarURL){ try{ URL.revokeObjectURL(tempAvatarURL);}catch(e){} tempAvatarURL = null; }
                // set preview to placeholder
                if(editAvatarPreview) editAvatarPreview.src = placeholderAvatar;
                if(undoRemoveAvatarBtn) undoRemoveAvatarBtn.classList.remove('hidden');
                if(willRemoveNote) willRemoveNote.classList.remove('hidden');
            });
        }

        // Undo remove
        if(undoRemoveAvatarBtn){
            undoRemoveAvatarBtn.addEventListener('click', function(){
                if(!removeAvatarInput) return;
                removeAvatarInput.value = '0';
                // restore preview to original or temp if exists
                if(tempAvatarURL){
                    editAvatarPreview.src = tempAvatarURL;
                }else{
                    editAvatarPreview.src = originalAvatarSrc || placeholderAvatar;
                }
                undoRemoveAvatarBtn.classList.add('hidden');
                willRemoveNote && (willRemoveNote.classList.add('hidden'));
            });
        }

        // Password Modal
        const passwordModal = document.getElementById('changePasswordModal');
        const openPasswordBtn = document.getElementById('openPasswordBtn');
        const closePasswordBtn = document.getElementById('closePasswordBtn');
        const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');
        const passwordOverlay = document.getElementById('passwordModalOverlay');
        const savePasswordBtn = document.getElementById('savePasswordBtn');

        function openPasswordModal(){
            passwordModal.classList.remove('hidden');
            passwordModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        function closePasswordModal(){
            passwordModal.classList.add('hidden');
            passwordModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        openPasswordBtn && openPasswordBtn.addEventListener('click', openPasswordModal);
        closePasswordBtn && closePasswordBtn.addEventListener('click', closePasswordModal);
        cancelPasswordBtn && cancelPasswordBtn.addEventListener('click', closePasswordModal);
        passwordOverlay && passwordOverlay.addEventListener('click', closePasswordModal);

        savePasswordBtn && savePasswordBtn.addEventListener('click', function(){
            closePasswordModal();
        });

        // Logout with SweetAlert2
        try{
            const logoutForm = document.getElementById('logoutForm');
            if(logoutForm){
                logoutForm.addEventListener('submit', function(e){
                    e.preventDefault();
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: 'Anda akan keluar dari sesi saat ini.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#06b6d4',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Logout',
                        cancelButtonText: 'Batal'
                    }).then((result)=>{
                        if(result.isConfirmed){
                            logoutForm.submit();
                        }
                    });
                });
            }
        }catch(e){}

        // Close on Escape
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape'){
                if(!editModal.classList.contains('hidden')) closeEditModal();
                if(!passwordModal.classList.contains('hidden')) closePasswordModal();
                if(imageViewerModal && !imageViewerModal.classList.contains('hidden')) closeImageViewer();
            }
        });

        // Move modals to document.body to avoid clipping by any parent stacking context
        try{
            if(editModal && editModal.parentNode !== document.body) document.body.appendChild(editModal);
            if(passwordModal && passwordModal.parentNode !== document.body) document.body.appendChild(passwordModal);
        }catch(e){}

        // Image Viewer: element refs
        const imageViewerModal = document.getElementById('imageViewerModal');
        const imageViewerOverlay = document.getElementById('imageViewerOverlay');
        const imageViewerImg = document.getElementById('imageViewerImg');
        const imageViewerClose = document.getElementById('imageViewerClose');

        // open viewer with src
        function openImageViewer(src){
            if(!imageViewerModal) return;
            imageViewerImg.src = src || '';
            imageViewerModal.classList.remove('hidden');
            imageViewerModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }
        function closeImageViewer(){
            if(!imageViewerModal) return;
            imageViewerModal.classList.add('hidden');
            imageViewerModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
            // optionally clear src to release memory
            imageViewerImg.src = '';
        }

        // open when clicking header avatar or preview (if present)
        profileAvatar && profileAvatar.addEventListener('click', function(){ openImageViewer(this.src); });
        editAvatarPreview && editAvatarPreview.addEventListener('click', function(){ openImageViewer(this.src); });

        // close handlers
        imageViewerClose && imageViewerClose.addEventListener('click', closeImageViewer);
        imageViewerOverlay && imageViewerOverlay.addEventListener('click', closeImageViewer);
        // ensure image viewer is appended to body too
        try{
            if(imageViewerModal && imageViewerModal.parentNode !== document.body) document.body.appendChild(imageViewerModal);
        }catch(e){}
    })();
</script>
@endsection
