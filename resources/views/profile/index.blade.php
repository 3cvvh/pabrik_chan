{{-- filepath: c:\laragon\www\pabrik_chan\resources\views\profile\index.blade.php --}}
@extends('layout.main')
@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden">
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
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
            <div class="flex items-center gap-4">
                <img id="profileAvatar" src="{{ asset('storage/' . $data->profile_picture_path) }}" alt="Avatar" class="w-28 h-28 rounded-full ring-4 ring-white object-cover">
                <div class="text-white">
                    <h1 class="text-2xl font-bold">{{ $data->name }} <span class="ml-2 inline-block px-2 py-0.5 text-sm bg-white/20 rounded">{{ $data->role_id == null ? "no role" : $data->role->name }}</span></h1>
                    <p class="text-sm opacity-90">{{ $data->email }}</p>
                    <p class="text-xs opacity-80 mt-1">{{ $data->pabrik->name }}  {{ $data->role_id == 2 ? "·" . $data->gudang->nama : "" }} </p>
                </div>
                <div class="ml-auto flex gap-2">
                    <!-- changed: button opens modal -->
                    <button id="openEditBtn" class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-lg text-sm font-medium shadow-sm hover:opacity-95">Edit</button>
                    <button id="openPasswordBtn" class="inline-flex items-center px-4 py-2 border border-white/40 text-white rounded-lg text-sm hover:bg-white/10">Change Pass</button>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2 bg-gray-50 p-4 rounded-lg">


                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700">
                        <div><span class="font-medium">Phone:</span>{{ $data->phone }}</div>
                        <div><span class="font-medium">Address:</span>{{ $data->alamat }}</div>
                        <div><span class="font-medium">Pabrik:</span> {{ $data->pabrik->name }}</div>
                        @if ($data->role_id == 2)
                        <div><span class="font-medium">Gudang:</span> Gudang A</div>
                        @endif
                    </div>
                </div>

            </div>

            <div class="flex flex-wrap gap-3">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                <button class="px-4 py-2 border border-gray-200 rounded-lg text-sm">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal: Change Password -->
<div id="changePasswordModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <!-- overlay -->
    <div id="passwordModalOverlay" class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md mx-4 overflow-hidden z-10">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Change Password</h2>
            <button id="closePasswordBtn" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <form action="{{ route('profile.changePassword',$data->id) }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-600">Current Password</label>
                <input type="password" name="current_password" class="mt-1 block w-full border rounded px-3 py-2 text-sm" placeholder="Enter current password">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600">New Password</label>
                <input type="password" name="password" class="mt-1 block w-full border rounded px-3 py-2 text-sm" placeholder="Enter new password">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600">Confirm Password</label>
                <input type="password" name="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2 text-sm" placeholder="Confirm new password">
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="cancelPasswordBtn" class="px-4 py-2 bg-gray-100 rounded text-sm">Cancel</button>
                <button type="submit" id="savePasswordBtn" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Update Password</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal: Edit Profile -->
<div id="editProfileModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <!-- overlay -->
    <div id="modalOverlay" class="absolute inset-0 bg-black/50"></div>

    <div class="relative bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden z-10">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Edit Profile</h2>
            <button id="closeEditBtn" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <form method="POST" enctype="multipart/form-data" action="{{ route('user.update',$data->id) }}" id="editProfileForm" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="flex items-center gap-4">
                <!-- Avatar preview in modal -->
                <img id="editAvatarPreview" src="https://placehold.co/128x128/avatar.png" alt="Avatar Preview" class="w-20 h-20 rounded-full object-cover ring-2 ring-gray-200">
                <div>
                    <label class="block text-xs font-medium text-gray-600">Upload Avatar</label>
                    <input name="gambar" id="avatarInput" type="file" class="mt-1 block text-sm">
                    <p class="text-xs text-gray-500 mt-1">PNG/JPG, max 2MB (preview otomatis)</p>
                </div>
            </div>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                     <label class="block text-xs font-medium text-gray-600">Name</label>
                     <input type="text" name="name" value="{{ $data->name }}" class="mt-1 block w-full border rounded px-3 py-2 text-sm">
                 </div>
                 <div>
                     <label class="block text-xs font-medium text-gray-600">Email</label>
                     <input type="email" name="email" value="{{ $data->email }}" class="mt-1 block w-full border rounded px-3 py-2 text-sm">
                 </div>
                 <div class="">
                     <label class="block text-xs font-medium text-gray-600">Phone</label>
                     <input type="text" name="phone" value="{{ $data->phone }}" class="mt-1 block w-full border rounded px-3 py-2 text-sm">
                 </div>
                 <div class="">
                     <label class="block text-xs font-medium text-gray-600">Address</label>
                     <input type="text" name="alamat" value="{{ $data->alamat }}" class="mt-1 block w-full border rounded px-3 py-2 text-sm">
                 </div>
             </div>

             <div class="flex justify-end gap-3 pt-2">
                 <a href="{{ route('user.index') }}"  class="px-4 py-2 bg-gray-100 rounded text-sm">Cancel</a>
                 <!-- Replace with actual submit action later -->
                 <button type="submit" id="saveEditBtn" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Save</button>
             </div>
         </form>
     </div>
 </div>

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
                // use the preview src (object URL) as header avatar for instant feedback
                profileAvatar.src = editAvatarPreview.src;
                // keep tempAvatarURL until modal closed where it will be revoked
            }
            closeEditModal();
        });

        // Handle avatar file selection -> preview
        if(avatarInput && editAvatarPreview){
            avatarInput.addEventListener('change', function(e){
                const file = this.files && this.files[0];
                if(!file) return;
                // simple file type check
                if(!file.type.startsWith('image/')) return;
                // revoke previous temp url
                if(tempAvatarURL) URL.revokeObjectURL(tempAvatarURL);
                tempAvatarURL = URL.createObjectURL(file);
                editAvatarPreview.src = tempAvatarURL;
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

        // Close on Escape
        document.addEventListener('keydown', function(e){
            if(e.key === 'Escape'){
                if(!editModal.classList.contains('hidden')) closeEditModal();
                if(!passwordModal.classList.contains('hidden')) closePasswordModal();
            }
        });
    })();
</script>
@endsection
