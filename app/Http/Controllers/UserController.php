<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function updateProfilePicture(Request $request)
{
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:16384',
    ]);

    $user = Auth::user();

    // Delete old profile picture if exists
    if ($user->profile_picture) {
        Storage::delete($user->profile_picture);
    }

    // Store new profile picture
    $path = $request->file('profile_picture')->store('profile_pictures', 'public');

    // Update user profile
    $user->profile_picture = $path;
    $user->save();

    return response()->json(['message' => 'Profile picture updated successfully!', 'path' => Storage::url($path)]);
}

    public function edit()
    {
        return view('profile.edit');  // For resources/views/profile/edit.blade.php
    }

}

