<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {


            $user = auth()->user();

            return view('pages.laundry.profile',[
                'user' => $user
            ]);

    }


    public function update($id, Request $request)
    {
        $attributes = $request->validate([
            'nama' => 'sometimes',
            'email' => 'sometimes|email',
            'no_hp' => 'sometimes',
            'gambar_profile' => 'sometimes|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('gambar_profile')) {
            $file = $request->file('gambar_profile');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public', $fileName);

            $attributes['gambar_profile'] = $fileName;
        }

        $user->update($attributes);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }


    }

