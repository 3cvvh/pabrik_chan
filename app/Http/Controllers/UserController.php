<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    // ...existing code...

    public function update(Request $request, $id)
    {
        // ...existing validation / lookup ...
        $user = User::findOrFail($id);

        // ...existing code for updating other fields ...

        // --- AVATAR HANDLING (added) ---
        // If remove flag set, delete stored file and clear DB column
        if ($request->input('remove_avatar') == '1') {
            if ($user->profile_picture_path) {
                try {
                    Storage::disk('public')->delete($user->profile_picture_path);
                } catch (\Throwable $e) {
                    // ignore delete errors or log if desired
                }
            }
            $user->profile_picture_path = null;
        }

        // If new file uploaded, store it and replace old one
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            // delete old file if exists
            if ($user->profile_picture_path) {
                try { Storage::disk('public')->delete($user->profile_picture_path); } catch (\Throwable $e) {}
            }
            $path = $request->file('gambar')->store('avatars', 'public'); // stored in storage/app/public/avatars
            $user->profile_picture_path = $path;
        }
        // --- end avatar handling ---

        // ...existing code to set other attributes...
        // e.g. $user->name = $request->input('name'); ...

        $user->save();

        // ...existing redirect/response ...
    }
    // ...existing code...
}
